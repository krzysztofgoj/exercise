# DIGITREE Group REST API
It is a REST API project in Symfony 5 written in PHP 7.

[API documentation](http://localhost:8080/api)

## Prerequisites
- Docker version 20+ `docker --version`
- docker-compose version 1.29+ `docker-compose --version`

## Project setup for developers
1. Run `make start` in the main directory
2. Run `make composer-install` for install dependencies
3. Run `make create-database` for create database in `db` catalog.
4. Execute database migrations `make database-migrate`

## Development
- `make enter` - enter via bash to PHP & nginx container
- `make composer-install` - install dependencies
- `make database-migrate` - execute database migrations
