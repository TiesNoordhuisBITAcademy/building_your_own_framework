[site](http://BYOF/)

This folder is symlinked to /var/www/BYOF_serve  
The config is located in /etc/apache2/sites-available/BYOF.conf  

The `.htaccess` redirect all requests to `index.php`
The default content would be
```
RewriteEngine on

RewriteRule ^(.*)$ index.php [NC,L,QSA]
```