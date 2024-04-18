## php version
- 8.2
## Setup project
- run command composer i
- cp .env.example .env
## Generate api swagger
- php artisan l5-swagger:generate

## Migration and seeder
- php artisan migrate --seed

## Run sever
- php artisan ser

## Url web
- http://127.0.0.1:8000

## Url api documentation
- http://127.0.0.1:8000/api/documentation

## Data user test
- email: 'test@example.com'
- password: 12345678

## Data user test
- run command cp .env.example .env.testing
- run command php artisan test

