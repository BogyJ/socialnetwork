# Social Network Web Application
* Social web app [link](https://pentestingdomain.xyz)

## Prerequisites
* php 5.6+
* composer 2.0.9
* Install the composer dependencies used for this project
```
composer install
```
* After installation you need to update dependencies
```
composer update
composer dump auto-load
```

## How to deploy
* You only need to change parameters in `Configuration.php` file and `.htaccess` file to match your directory path in which the project is located
* `BASE` --> change it to base url (where is your project located), for example: `http://localhost` is in root of `htdocs` folder __DO NOT ENTER SLASH (/) AT THE END OF URL__ ~~(`http://localhost/`)~~
* `DATABASE_HOST` --> database hostname, default `localhost`
* `DATABASE_USER` --> database username, default `root`
* `DATABASE_PASSWORD` --> database password for provided user
* `DATABASE_NAME` --> database schema name
* Link to `.sql` [database file](https://drive.google.com/file/d/1QanG7XHw62o27_XnJ0BcQlPKbqEABT0C/view?usp=sharing)

## To do
- [x] Initial setup - clone from template and setup env locally
- [x] Implement login and register functionality
- [x] Implement friend request functionality
- [ ] Implement post functionality, including liking and commenting on the post (only users who are friends will be able to comment)
- [x] Deploy to a live web server :tada:
