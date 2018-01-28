# Teste crud

This is a basic application for a test on [Eduzz.com](https://eduzz.com/ "Eduzz")

## Api

The api for this test, was build with the lumen microframework.

### CookBook

Enter in /api folder

Create the .env file with the .env.example

Then, install the dependencies

```sh
composer install
```

Run the migration with

```sh
php artisan migrate
```

And finally, use the php to run a basic server inside of /api

```sh
php -S localhost:8000 -t public
```

### Routes

| METHOD        | ROUTE           | RETURN  |
| ------------- |:-------------:| -----:|
| GET      | /candidate | List of all candidates |
| GET      | /candidate/:id | Show the specific candidate |
| POST      | /candidate | Create a new candidate |

## Interface

The interface is build with basic's of Html, Css, Vanilla Javascript and Gulp to create a basic server.
