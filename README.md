CRUD Admin Generator
===================

# Note: To get this working, I had to remove schema validation in Symfony/Translation XLiffFileLoader.php.

What is CRUD Admin Generator?
-----------------------------

**CRUD Admin Generator** ([http://crud-admin-generator.com][1]) is a tool to **generate a complete backend from a SQL Server database** where you can create, read, update and delete records in a database. 

**The backend is generated in seconds** without configuration files where there is a lot of *"magic"* and is very difficult to adapt to your needs. 

**The generated code is fully customizable and extensible.**

It has been programmed with the Silex framework, so the resulting code is PHP.

It also comes with Doctrine ORM so you can easily edit the generated code to work with objects directly rather than SQL. This makes things like JOINs much easier.

Installation
------------

Clone the repository

    git clone https://github.com/smith981/crud-admin-generator.git admingenerator

    cd admingenerator

Download composer:

    curl -sS https://getcomposer.org/installer | php

Install vendors:

    php composer.phar install

You need point the document root of your virtual host to /path_to/admingenerator/web

This is an example of VirtualHost:

    <VirtualHost *:80>
        DocumentRoot /path_to/admingenerator/web
        DirectoryIndex index.php
        <Directory "/path_to/admingenerator/web">
            Options Indexes FollowSymLinks
            Order Allow,Deny
            Allow from all
            AllowOverride all
            <IfModule mod_php5.c>
                php_admin_flag engine on
                php_admin_flag safe_mode off
                php_admin_value open_basedir none
            </ifModule>
        </Directory>
    </VirtualHost>
    
You can customize the url using the .htaccess file, maybe this will help you:
[http://stackoverflow.com/questions/24952846/how-do-i-remove-the-web-from-my-url/24953439#24953439](http://stackoverflow.com/questions/24952846/how-do-i-remove-the-web-from-my-url/24953439#24953439)


Generate CRUD backend
---------------------

Edit the file /path_to/admingenerator/src/app.php and set your database conection data:
```php
<?php
//...
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'db' => array(
            'driver'   => 'pdo_mysql',
            'dbname'   => 'DATABASE_NAME',
            'host'     => 'localhost',
            'user'     => 'DATABASE_USER',
            'password' => 'DATABASE_PASS',
            'charset'  => 'utf8',
        ),
    )
));
```

Edit the file /path_to/admingenerator/bootstrap.php to insert your database config info:
```php
<?php
// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite', //don't need this except for SQLITE
    //'dbname'   => '',
    //'host'     => '',
    //'user'     => '',
    //'password' => '',
);
```

You need to set the url of the resources folder.

Change this line:

    $app['asset_path'] = '/resources';

For the url of your project, for example:

    $app['asset_path'] = 'http://domain.com/crudadmin/resources';


Now, execute the command that will generate the CRUD backend:

    php console generate:admin

**This is it!** Now access with your favorite web browser.

The command generates one menu section for each database table. **Now will be much easier to list, create, edit and delete rows!**


Customize the result
--------------------

The generated code is fully configurable and editable, you just have to edit the corresponding files.

 - The **controller** you can find it in **/web/controllers/TABLE_NAME/index.php**
 - The **views** are in **/web/views/TABLE_NAME**

It has generated a folder for each database table.

Known Issues
------------

If you have more than 6 columns in a table, your index route may throw a JS error and it will not list the contents. The workaround is to edit the generated code in the index.php file in web/controllers/yourEntityName. You just need to comment out the extraneous columns in the $table_columns variable inside the index route. For example

```php
<?php
//... web/controllers/Expert/index.php
$app->match('/Expert', function () use ($app) {
    
    $table_columns = array(
        'id', 
        'status', 
        'firstName', 
        'lastName', 
        'position', 
        'photoUrl', 
        //'education', //Remove these two columns so they don't show up in the index view
        //'biography', 
//...
    );

    $primary_key = "id";    
```

Contributing
------------

If you want to contribute code to CRUD Admin Generator, we are waiting for your pull requests!

Some suggestions for improvement could be:

 - Different form fields depending on data type.: datetime, time...
 - Create admin user with a login and logout page.
 - Generate CRUD for tables with more than one primary key.
 - Any other useful functionality!

Author
------

* Jon Segador <info@jonsegador.com>
* Personal site: [http://jonsegador.com/](http://jonsegador.com/)
* Twitter: *[@jonseg](https://twitter.com/jonseg)*
* CRUD Admin Generator webpage: [http://crud-admin-generator.com](http://crud-admin-generator.com)


  [1]: http://crud-admin-generator.com
