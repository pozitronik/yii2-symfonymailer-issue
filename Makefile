CID = $(shell docker ps -aqf "name=test_php")

build-x86:
	PLATFORM=x86 docker-compose up -d --build

build-arm:
	PLATFORM=arm docker-compose up -d --build

start-arm:
	PLATFORM=arm UID="$(id -u)" GID="$(id -g)" docker-compose up -d

start-x86:
	PLATFORM=x86 UID="$(id -u)" GID="$(id -g)" docker-compose up -d

force up:
	docker-compose up -d --build --force-recreate

restart:
	docker-compose restart

down-arm:
	PLATFORM=arm UID="$(id -u)" GID="$(id -g)" docker-compose down

down-x86:
	PLATFORM=x86 UID="$(id -u)" GID="$(id -g)" docker-compose down

stop:
	docker-compose stop

exec:
	docker exec -ti $(or $(s), $(service)) sh

composer:
	@docker exec -i ${CID} sh -c "composer install"

run-php:
	docker exec -it test_php sh

setup: prepare build-$(p) init

clean:
	docker system prune -a
	docker volume prune