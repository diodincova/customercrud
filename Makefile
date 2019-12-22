create: up composer migrate
up:
	docker-compose -f docker-compose.yml up --build --force-recreate -d
down:
	docker-compose -f docker-compose.yml down -v
build:
	docker-compose -f docker-compose.yml build --no-cache
migrate:
	docker-compose -f docker-compose.yml exec -T php vendor/bin/doctrine-migrations migrate --no-interaction --allow-no-migration
fixtures:
	docker-compose -f docker-compose.yml exec -T php bin/fixtures
composer:
	docker-compose -f docker-compose.yml exec -T php composer install --prefer-dist -o