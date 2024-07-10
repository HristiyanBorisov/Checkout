build:
	make down
	docker compose up -d --build
	sleep 5
	make composer
	make wipe-db
	docker exec laravel-app php artisan migrate
	docker exec laravel-app php artisan db:seed
up:
	docker compose up -d

stop:
	docker compose stop

wipe-db:
	docker exec laravel-app php artisan db:wipe

down:
	docker compose down

composer:
	docker exec laravel-app composer install
