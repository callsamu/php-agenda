# PHP Agenda
A simple (and incomplete) web app for keeping track of your day-to-day tasks
and deadlines. Done without any frameworks.

## Installation and Setup
For this to work, you only need PHP 8.0 and Composer installed.

### Using PHP's built-in server
```git clone "https://github.com/callsamu/php-agenda"```

```composer install```

Create the database and run the migrations:

```touch var/data/database.sqlite```

```vendor/bin/doctrine-migrations migrate```

Start the server:

```php -S localhost:80 -t public```

And open your browser on localhost.

### Setup with Docker [recommended]

You must have docker and docker-compose installed.

```git clone "https://github.com/callsamu/php-agenda"```

```docker-compose build```

```docker-compose run php vendor/bin/doctrine-migrations migrate```

```docker-compose up -d```

I still need to create override files for development and production, but this should work fine.


