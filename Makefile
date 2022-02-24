build:
	docker-compose build --no-cache

run-app:
	docker-compose run --rm app

run-tests:
	docker-compose run --rm -e XDEBUG_MODE=coverage app ./vendor/bin/phpunit tests --colors --testdox --coverage-html=.coverage

run-mutation-tests:
	docker-compose run --rm -e XDEBUG_MODE=coverage app ./vendor/infection/infection/bin/infection --only-covered --threads=10