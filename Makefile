build:
	docker-compose build --no-cache

run-app:
	docker-compose run --rm app

run-tests:
	docker-compose run --rm app ./vendor/bin/phpunit tests --colors --testdox --coverage-html=.coverage