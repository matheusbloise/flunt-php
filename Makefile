all: ci

ci:
	@docker-compose up -d
	@docker-compose exec flunt composer install
	@docker-compose exec flunt composer analyze
	@docker-compose exec flunt composer test
	@docker-compose down
