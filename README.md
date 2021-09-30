# Social Network Web Application
* Link to web app: https://pentestingdomain.xyz (not live yet)

## Prerequisites
* php 5.6+
* composer 2.0.9
* In order to deploy locally run `composer install` to install the dependencies used for this project
* After installation run `composer update` to update dependencies

## How to deploy
* You only need to change parameters in `Configuration.php` file
* `BASE` --> change it to base url (where is your project located), for example: `http://localhost` __DO NOT ENTER SLASH (/) AT THE END OF URL__
* `DATABASE_HOST` --> database hostname, default `localhost`
* `DATABASE_USER` --> database username, default `root`
* `DATABASE_PASSWORD` --> database password for provided user
* `DATABASE_NAME` --> database schema name

## To do
- [x] Initial setup - clone from template and setup env locally
- [x] Implement login and register functionality
- [x] Implement friend request functionality
- [ ] Implement post functionality, including liking and commenting on the post (only users who are friends will be able to comment)
- [ ] Deploy to a live web server :tada: