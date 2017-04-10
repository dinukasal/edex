Deploying the App
----------------
Following instructions are for apache 

1. Clone the repo and install composer and laravel dependencies

2. Follow this url to deploy the laravel app,

https://medium.com/laravel-news/the-simple-guide-to-deploy-laravel-5-application-on-shared-hosting-1a8d0aee923e

3. Change httpd.conf "AllowOverride None" to "AllowOverride All" to make routing work with .htaccess file. (Please make sure to include .htaccess file in /var/www/html/)
