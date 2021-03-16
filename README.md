# Currency Conversion API

## Pre-requisites

- Docker locally.
- Git installed locally.
- PHP installed locally.
- [Composer](https://getcomposer.org/download/) installed locally.
- An API Access Key tied to a valid account in [fixer.io](https://fixer.io/) subscribed to the basic plan.
- Before starting, you should ensure that no other web servers or databases are running on your local computer.

## Requisites

- Clone the repository locally with `git clone git@github.com:JesusGarciaValadez/Currency-Converter-API.git`.
- Accessing to the repository with `cd Currency-Converter-API`;
- Copy the `.env.example` file as `.env` and `.env.testing` files.
- Replace the following values in the `.env` file:
```
APP_NAME=
APP_URL=
...
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
...
FIXER_API_KEY=
  ```
- For the `APP_URL` you can use the `http://localhost`.
- For the `.env.testing` file, you can leave the current values if you want.
- You can use wherever values do you want to use for the database setup.
- You need your **Fixer's API Access Key** for the `FIXER_API_KEY` environment variable.


## Installation instructions

### How to create the container?

- Install the composer dependencies with `composer install`;
- Run the command `php artisan sail:install` to publish the necessary for Docker to run.
- Create the Docker container using `./vendor/bin/sail up -d` for the detached mode.
- This will create the container using some environment variables of your `.env` file.

### How to create the database?

Once the container was created and running, you have to run the following commands:
```
./vendor/bin/sail artisan key:generate;
./vendor/bin/sail artisan migrate:fresh;
./vendor/bin/sail artisan migrate:fresh --env=testing;
```.

### How to access the API?

You can access the API through `http://localhost/api/currency/conversion` endpoint.

### How to run the tests?

You can run the following command `./vendor/bin/sail test`.

### How to interact with the database?

You can access the database using `127.0.0.1` as `host` and the same values for the `DB_USERNAME`, `DB_PASSWORD`, and `DB_USERNAME` stored in your `.env` file.

### How to stop the containers?

You can stop the containers using `./vendor/bin/sail down`.

### What if I already had installed the docker images and containers before?

You need to recreate the container running `docker-compose build`, or stop the containers and images, delete them, and run `./vendor/bin/sail up -d` to download the images again and rebuild them.

## How to use the API?

The only endpoint available is a `POST` request to `/api/currency/conversion`. The payload accepted is something like the following:

```
{
"source_currency": "USD",
"target_currency": "DKK",
"value": "1000",
}
```

All the fields are mandatory to get a proper response like the following:

```
{
...
"source_currency": "USD",
"target_currency": "DKK",
"value": "1000",
"amount_converted": "6247.66",
"rate": "6.24766",
"timestamp": "1615934226",
...
}
```

If any of the fields are missed, or any of the currency fields have an invalid currency, then you'll have an error.

## Deploy to production

You can see the result of the API deployed to [production](http://104.238.181.200/api/currency/conversion)
