provider "google" {
  project = var.project_id
  region  = var.region
}

locals {
  common_labels = {
    project     = "directory"
    environment = "production"
    managed_by  = "terraform"
  }
}

# VPC Network
resource "google_compute_network" "vpc_network" {
  name                    = "directory-network"
  auto_create_subnetworks = true
}

resource "google_compute_global_address" "private_ip_address" {
  name          = "private-ip-address"
  purpose       = "VPC_PEERING"
  address_type  = "INTERNAL"
  prefix_length = 16
  network       = google_compute_network.vpc_network.id
}

resource "google_service_networking_connection" "private_vpc_connection" {
  network                 = google_compute_network.vpc_network.id
  service                 = "servicenetworking.googleapis.com"
  reserved_peering_ranges = [google_compute_global_address.private_ip_address.name]
}

# Serverless VPC Access Connector
resource "google_vpc_access_connector" "connector" {
  name          = "directory-vpc-conn"
  region        = var.region
  network       = google_compute_network.vpc_network.name
  ip_cidr_range = "10.8.0.0/28"
  machine_type  = "e2-micro"
  min_instances = 2
  max_instances = 3
}

# Cloud SQL
resource "google_sql_database_instance" "main" {
  name             = "directory-postgres"
  database_version = "POSTGRES_16"
  region           = var.region

  settings {
    tier              = "db-g1-small"
    disk_size         = 20
    disk_type         = "PD_SSD"
    disk_autoresize   = true

    ip_configuration {
      ipv4_enabled    = false
      private_network = google_compute_network.vpc_network.id
    }

    backup_configuration {
      enabled                        = true
      start_time                     = "02:00"
      point_in_time_recovery_enabled = true
      backup_retention_settings {
        retained_backups = 7
        retention_unit   = "COUNT"
      }
    }
    user_labels = local.common_labels
  }

  depends_on = [google_service_networking_connection.private_vpc_connection]
}

resource "google_sql_database" "database" {
  name     = "directory"
  instance = google_sql_database_instance.main.name
}

resource "google_sql_user" "users" {
  name     = "directory_user"
  instance = google_sql_database_instance.main.name
  password = "changeme" # Update via Secret Manager / out-of-band
}

# Cloud Memorystore (Redis)
resource "google_redis_instance" "main" {
  name           = "directory-redis"
  tier           = "BASIC"
  memory_size_gb = 1
  region         = var.region
  redis_version  = "REDIS_7_0"

  authorized_network = google_compute_network.vpc_network.id
  labels             = local.common_labels
}

# Cloud Storage Bucket
resource "google_storage_bucket" "media" {
  name          = "${var.project_id}-directory-media"
  location      = var.region
  force_destroy = false

  uniform_bucket_level_access = true

  cors {
    origin          = ["*"]
    method          = ["GET", "HEAD", "OPTIONS"]
    response_header = ["*"]
    max_age_seconds = 3600
  }

  lifecycle_rule {
    action {
      type = "AbortIncompleteMultipartUpload"
    }
    condition {
      age = 1
    }
  }

  labels = local.common_labels
}

resource "google_storage_bucket_iam_member" "public_read" {
  bucket = google_storage_bucket.media.name
  role   = "roles/storage.objectViewer"
  member = "allUsers"
}

# Artifact Registry
resource "google_artifact_registry_repository" "repo" {
  location      = var.region
  repository_id = "directory"
  description   = "Docker repository for directory application"
  format        = "DOCKER"
  labels        = local.common_labels
}

# Secret Manager Secrets
resource "google_secret_manager_secret" "app_key" {
  secret_id = "app-key"
  replication {
    auto {}
  }
  labels = local.common_labels
}

resource "google_secret_manager_secret" "db_password" {
  secret_id = "db-password"
  replication {
    auto {}
  }
  labels = local.common_labels
}

resource "google_secret_manager_secret" "mail_username" {
  secret_id = "mail-username"
  replication {
    auto {}
  }
  labels = local.common_labels
}

resource "google_secret_manager_secret" "mail_password" {
  secret_id = "mail-password"
  replication {
    auto {}
  }
  labels = local.common_labels
}

# Cloud Run Service
resource "google_cloud_run_service" "default" {
  name     = "directory"
  location = var.region

  template {
    spec {
      containers {
        image = "us-docker.pkg.dev/cloudrun/container/hello" # Placeholder image, updated by Cloud Build
        resources {
          limits = {
            memory = "512Mi"
            cpu    = "1000m"
          }
        }
      }
      container_concurrency = 80
      timeout_seconds       = 30
    }
    metadata {
      annotations = {
        "run.googleapis.com/vpc-access-connector" = google_vpc_access_connector.connector.name
        "run.googleapis.com/vpc-access-egress"    = "private-ranges-only"
        "autoscaling.knative.dev/minScale"        = "1"
        "autoscaling.knative.dev/maxScale"        = "10"
      }
    }
  }

  traffic {
    percent         = 100
    latest_revision = true
  }

  lifecycle {
    ignore_changes = [
      template[0].spec[0].containers[0].image,
      template[0].metadata[0].annotations,
    ]
  }

  labels = local.common_labels
}

resource "google_cloud_run_service_iam_member" "public_access" {
  service  = google_cloud_run_service.default.name
  location = google_cloud_run_service.default.location
  role     = "roles/run.invoker"
  member   = "allUsers"
}

# Load Balancer & Cloud Armor
resource "google_compute_global_address" "default" {
  name = "directory-lb-ip"
}

resource "google_compute_region_network_endpoint_group" "cloudrun_neg" {
  name                  = "directory-cloudrun-neg"
  network_endpoint_type = "SERVERLESS"
  region                = var.region
  cloud_run {
    service = google_cloud_run_service.default.name
  }
}

resource "google_compute_security_policy" "armor_policy" {
  name = "directory-armor-policy"

  rule {
    action   = "allow"
    priority = "2147483647"
    match {
      versioned_expr = "SRC_IPS_V1"
      config {
        src_ip_ranges = ["*"]
      }
    }
    description = "default rule"
  }

  rule {
    action   = "deny(403)"
    priority = "1000"
    match {
      expr {
        expression = "evaluatePreconfiguredExpr('sqli-v33-stable')"
      }
    }
    description = "Block SQL injection"
  }
  
  rule {
    action   = "deny(403)"
    priority = "1001"
    match {
      expr {
        expression = "evaluatePreconfiguredExpr('xss-v33-stable')"
      }
    }
    description = "Block XSS"
  }
}

resource "google_compute_backend_service" "default" {
  name                  = "directory-backend"
  protocol              = "HTTPS"
  port_name             = "http"
  load_balancing_scheme = "EXTERNAL"
  security_policy       = google_compute_security_policy.armor_policy.id

  backend {
    group = google_compute_region_network_endpoint_group.cloudrun_neg.id
  }
}

resource "google_compute_url_map" "default" {
  name            = "directory-url-map"
  default_service = google_compute_backend_service.default.id
}

resource "google_compute_url_map" "https_redirect" {
  name = "directory-https-redirect"

  default_url_redirect {
    https_redirect         = true
    redirect_response_code = "MOVED_PERMANENTLY_DEFAULT"
    strip_query            = false
  }
}

resource "google_compute_managed_ssl_certificate" "default" {
  name = "directory-cert"

  managed {
    domains = [
      "*.co.zw",
      "*.co.za",
      "*.co.ke",
      "*.co.ng",
      "*.co.bw",
      "*.co.zm"
    ]
  }
}

resource "google_compute_target_https_proxy" "default" {
  name             = "directory-https-proxy"
  url_map          = google_compute_url_map.default.id
  ssl_certificates = [google_compute_managed_ssl_certificate.default.id]
}

resource "google_compute_global_forwarding_rule" "https" {
  name                  = "directory-https-rule"
  target                = google_compute_target_https_proxy.default.id
  port_range            = "443"
  ip_address            = google_compute_global_address.default.address
  load_balancing_scheme = "EXTERNAL"
}

resource "google_compute_target_http_proxy" "http_redirect" {
  name    = "directory-http-proxy"
  url_map = google_compute_url_map.https_redirect.id
}

resource "google_compute_global_forwarding_rule" "http" {
  name                  = "directory-http-rule"
  target                = google_compute_target_http_proxy.http_redirect.id
  port_range            = "80"
  ip_address            = google_compute_global_address.default.address
  load_balancing_scheme = "EXTERNAL"
}
