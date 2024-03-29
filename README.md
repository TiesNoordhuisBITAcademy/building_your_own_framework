# Persoonlijke uitwerking BYOF module

## Requirements

- Apache webserver
- PHP 8.1+
- Composer
- mysql/mariadb

### Packages from composer

- RedBeanPHP
- Twig

## Installatie

1. clone the repo
2. install the dependencies `composer install`
3. serve the root directory, see linux/ubuntu example below
4. create the database from the `import.sql` file
optional
5. seed the database by visiting <baseurl>/home/setup

### example server setup on ubuntu

[site](http://BYOF/)

Repository root folder is symlinked to /var/www/BYOF_serve  
```bash
ln -sf /home/user/repositories/building_your_own_framework /var/www/BYOF_serve 
```
The config is located in /etc/apache2/sites-available/BYOF.conf  
```conf
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName BYOF
    DocumentRoot /var/www/BYOF_serve
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
enable config
```bash
sudo a2ensite BYOF.conf
sudo systemctl reload apache2
```
## usage

The `.htaccess` redirect all requests to `index.php`
The default content would be
```
RewriteEngine on

RewriteRule ^(.*)$ index.php [NC,L,QSA]
```

`index.php` is responsible to the routing. All valid requests are send to the relevant controller and method with optionaly the arguments base on this pattern: `root_url/controller/method/param1/param2..`  
These values are also sent with each response using custom header keys `X-Controller` and `X-Method` for easy debugging.  
Controllers make use of services, specificly for displaying content (`ViewService`) and for data CRUD actions (services extended from `ORMService`)  
The ORM allows for mapping the data to models, which are specified in the `models` folder.  
