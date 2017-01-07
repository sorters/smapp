appname="smapp" # MODIFY APPNAME HERE (OPTIONAL)

# DO NOT MODIFY BELOW THIS LINE ########################

mv smapp.conf /etc/apache2/sites-available/$appname.conf

a2ensite $appname.conf

service apache2 reload

mkdir bootstrap/cache

sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

/usr/local/bin/composer.phar install

touch database/database.sqlite

php artisan migrate:install

sudo chgrp -R www-data database
sudo chmod -R ug+rwx database

php artisan migrate:refresh --seed -n --force

mv .env.production .env

php artisan key:generate
