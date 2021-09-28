# Social Network Web Application
* Link to web app: https://pentestingdomain.xyz

## Prerequisites
* php 5.6+
* composer
* In order to deploy locally run `composer install` to install the dependencies used for this project
* After installation run `composer update` to update dependencies

## How to deploy
* You only need to change parameters in `Configuration.php` file
* `BASE` --> change it to base url (where is your project located), for example: `http://localhost` __DO NOT ENTER SLASH (/) AT THE END OF URL__
* `DATABASE_HOST` --> database hostname, default `localhost`
* `DATABASE_USER` --> database username, default `root`
* `DATABASE_PASSWORD` --> database password for provided user
* `DATABASE_NAME` --> database schema name