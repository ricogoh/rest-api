# Simple Rest API With Token - Lumen Framework
Quick start with simple RESTful API server with web token based.

***This does not conform to the JWT standard, but it is useful for understanding how web tokens work.*

## Installation
```
composer install

php artisan migrate --seed
```
#### Important Scripts
* bootstrap/app.php
* app/Providers/AuthServiceProvider.php
* app/Http/Middleware/Authenticate.php

## References
https://code.tutsplus.com/tutorials/how-to-secure-a-rest-api-with-lumen--cms-27442

https://www.cloudways.com/blog/lumen-rest-api-authentication/
