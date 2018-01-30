# Teste crud

This is a basic application for a test on [Eduzz.com](https://eduzz.com/ "Eduzz")

## Api

The api for this test, was build with the lumen microframework.

### Api - Installation

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

### Api - Routes

| METHOD        | ROUTE           | RETURN  |
| ------------- |:-------------:| -----:|
| GET      | /candidate | List of all candidates |
| GET      | /candidate/:id | Show the candidate |
| POST      | /candidate | Create a new candidate |
| DELETE      | /candidate/:id | Delete the candidate |
| PATCH/PUT      | /candidate/:id | Update the candidate |

## Interface

The interface is built with basic's of Html, Css, Vanilla Javascript and Gulp to create a basic server.

### Interface - Installation

Enter in webapp folder and install the dependencies

```sh
sudo npm install --unsafe-perm
```

Run the test "server"

```sh
gulp browser-sync
```
