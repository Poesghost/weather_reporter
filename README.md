# `Weather Reporter`

## Table of Contents
1. [Requirements](#requirements)
2. [Getting Started](#getting-started)
3. [Custom Artisan Commands](#custom-artisan-commands)

## Requirements

This was built on Laravel 10 and its requirements are:
- requires a minimum PHP version of 8.1
- requires a minimum Node version of 18
- composer
- MySQL or MariaDB

[Back To The Top](#weather-reporter)

## Getting Started

After cloning this repo:

1. Copy the .env.example:

    ```bash
    cp .env.example .env
    ```

2. Within the new `.env` file, update a few values:

    ```
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```

3. Run:

    ```bash
    php artisan key:generate
    ```

4. Install Laravel dependencies:

    ```bash
    composer install
    ```

5. Run migrations:

    ```bash
    php artisan migrate
    ```

[Back To The Top](#weather-reporter)

## Custom Artisan Commands

### Get Zones

Populates the zones table that the weather.gov API supply.

```bash
php artisan get:zones
```

> _**NOTE:** Should run first and only once._

### Get Alerts

Populates the alerts table using zones that the weather.gov API supply.

```bash
php artisan get:alerts
```

> _**NOTE:** Still a work in progress._

[Back To The Top](#weather-reporter)
