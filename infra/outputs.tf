output "cloud_sql_private_ip" {
  description = "The private IP address of the Cloud SQL instance"
  value       = google_sql_database_instance.main.private_ip_address
}

output "redis_private_ip" {
  description = "The private IP address of the Redis instance"
  value       = google_redis_instance.main.host
}

output "load_balancer_ip" {
  description = "The IP address of the Load Balancer"
  value       = google_compute_global_address.default.address
}

output "storage_bucket_name" {
  description = "The name of the Cloud Storage bucket"
  value       = google_storage_bucket.media.name
}

output "cloud_run_url" {
  description = "The URL of the Cloud Run service"
  value       = google_cloud_run_service.default.status[0].url
}
