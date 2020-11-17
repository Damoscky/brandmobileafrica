# Brand Mobile Africa Assessment

## Description

An assessment to build a question management functionality 

## Prerequiste

<ul>
    <li>PHP 7</li>
    <li>Composer</li>
    <li>MySQL</li>
</ul>

## Postman Documentation

https://documenter.getpostman.com/view/9097878/TVep8TFz#33764157-24f2-4436-a253-ce98b49443a7


## Technologies used

Modern PHP technologies were adopted for this assessment

Laravel: Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.
Visit [here](https://laravel.com/) for more information.


Mysql - Relational Database System used in project.


## Installation

### Step 1.
- Begin by cloning this repository to your machine 
```
git clone https://github.com/Damoscky/brandmobileafrica.git

```

- Install dependencies
```
cd name && composer install
```

- Create enviromental file and variables
```
cp .env.example .env
```

- Generate app key
```
php artisan key:generate
```

### Step 2
- Next, create a new database and reference its name and username/password in the projects .env file. Below the database name is "question_management"
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=question_management
DB_USERNAME=root
DB_PASSWORD=
```


### Step 3
- To start the server, run the command below
```shell
$ php artisan serve
```





