<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

# Laravel Shugars

## Features:
- `Dockerize` - {`sqlite`, `mysql`, `mariadb`, `postgres`}
- `PHPMyAdmin`
- `PGAdmin`
- `Env`
- `GitHub Actions`
- `Gitlab CI`
- `Bitbucket Pipelines`

## Choose a Database and copy `ENV` file

- `sqlite`
- `mysql`
- `mariadb`
- `postgres`


- `sqlite` - Copy the `.env.example` to `.env` file

`OR`

- `mysql` - Copy the `.env.example.mysql` to `.env` file

`OR`

- `mariadb` - Copy the `.env.example.mariadb` to `.env` file

`OR`

- `postgres` - Copy the `.env.example.postgres` to `.env` file


## Install

```
{bun/deno/npm} install
```

```
composer install
```

```
php artisn key:generate
```

```
php artisan wayfinder:generate --with-form
```

```
php artisan storage:link
```

```
php artisan migrate
```

```
php artisan db:seed
```

## Start
+ No SQLite Database:
```
docker compose -f ./docker-compose-{mysql|mariadb|postgres}.yml up -d
```

```
{bun/deno/npm} run dev
```

```
php artisan serve
```

```
php artisan queue:work
```

```
php artisan reverb:start
```

## License
open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
