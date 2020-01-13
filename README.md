# Authentication API PHP

![](https://img.shields.io/badge/Code%20Style-Standard-yellow.svg)
![](https://img.shields.io/badge/Dependencies-JWT-green.svg)
![](https://img.shields.io/badge/License-ISC-yellowgreen.svg)

<p align="center">
  <a href="https://www.php.net/">
    <img alt="restfulapi" title="PHP" src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg">
  </a>
</p>
<p align="center">
  <a href="https://www.mysql.com/">
    <img alt="database" title="database management" src="https://seeklogo.net/wp-content/uploads/2012/03/mysql-vector1.jpg">
  </a>
</p>

----
## Table of contents
* [Prerequiste](#prerequiste)
* [Installation](#installation)
* [Documentation](#documentation)
* [License](#license)

## Prerequiste
- Postman - Download and Install [Postman](https://www.getpostman.com/downloads) - Implementation with postman latest version.
- Code Editor - Download and Install [VS Code](https://code.visualstudio.com/Download) - Code editor that i use to create this project.
- XAMPP - Download and Install [XAMPP](https://www.apachefriends.org/download.html) - XAMPP is a free and open-source cross-platform web server solution stack package developed by Apache Friends, consisting mainly of the Apache HTTP Server, MariaDB database, and interpreters for scripts written in the PHP and Perl programming languages. So, i don't need to install mysql anymore.

## Installation
### Clone
```
$ git clone https://github.com/Ertilu/authentication-api-php.git to xampp/htdocs/
$ cd xampp/htdocs/authentication-api-php
$ import the database using phpmyadmin

```
## How to run the app ?
1. Turn on Web Server and MySQL can using Third-party tool like xampp, etc.
2. Create a database with the name db_inventory, and Import file [db_api_login](db_api_login.sql) to **phpmyadmin**
3. Open Postman desktop application or Chrome web app extension that has installed before
4. Choose HTTP Method and enter request url.(ex. localhost/api)
5. You can see all the end point [here](#documentation)

## Documentation

### AUTHENTICATION Routes

#### POST Request
```
 1. "/api/create_user.php" => Create user and return token. 
    a. Required Body: 
       1) firstname: string
       2) lastname: string
       3) email: string
       4) password: string
       5) * date_created and date_updated: (auto created)

 2. "/api/login.php" => Log In user and return token. 
    a. Required Body:
       1) email: string
       2) password: string
       
 3. "/api/update_user.php" => Create user and return token. 
    a. Required Body: 
       1) firstname: string
       2) lastname: string
       3) email: string
       4) password: string
       6) jwt: string (jwt token generated after you login to the system)
```

### LEVELLING SYSTEM Routes

#### POST Request
```
 1. "/api/add_xp" => Add xp to to user to level up user when you call this API.
    b. Required Body: 
       1) jwt: string (jwt token generated after you login to the system)
```

### License
----
[ISC](https://en.wikipedia.org/wiki/ISC_license "ISC")
