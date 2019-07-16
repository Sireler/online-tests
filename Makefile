docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-build:
	docker-compose build

docker-containers:
	docker container ls -a

project-init: composer-install artisan-migrate assets-install assets-dev

composer-install:
	docker-compose run --rm php-cli composer install

artisan-migrate:
	docker-compose run --rm php-cli php artisan migrate --no-interaction

assets-install:
	docker-compose run --rm node npm install
	docker-compose run --rm node npm rebuild node-sass

assets-dev:
	docker-compose run --rm node npm run dev

fix-permission:
	sudo chgrp -R www-data storage bootstrap/cache
	sudo chmod -R ug+rwx storage bootstrap/cache
