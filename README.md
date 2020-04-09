Samuel PHP Rest API

Teste técnico EssenceIT
=============================

## Environment Requirements

In order to run this project, you'll need:

1. PHP 7.2+
2. PHP pdo, mysql, mstring and dom/xml extensions
3. MySQL 5.7
4. Composer

## Configuring The Database

After your environment has been configured, we need setup the database, and tables, to do so follow below steps.

1. `cd /path/to/teste-essenceit`
2. `cd mysql/scripts`
3. `mysql -h$HOST -u$USER -p$PWD < db.sql`

## Configuring The Project

After your database has been configured, we should setup our database settings, and install the dependecies, to do so follow below steps.

1. `cd /path/to/teste-essenceit`
2. `cd src`
5. `vi .env`
3. `composer install`

>Change the settings as needed, save and close the file.

## Running Unit Tests

Just run, `./path/to/teste-essenceit/run-tests.sh`

## Running The Project

In order to run this project follow below steps.

1. `php -S localhost:3000 -t /path/to/teste-essenceit/src/Public`

## Done!
Now that you've configured your environement and the project, it should be working at http://localhost:3000
