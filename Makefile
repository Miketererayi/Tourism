.PHONY: up down shell migrate seed logs build fresh

up:
	docker compose up -d

down:
	docker compose down

shell:
	docker compose exec app sh

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

logs:
	docker compose logs -f app

build:
	docker compose build --no-cache

fresh:
	docker compose exec app php artisan migrate:fresh --seed
