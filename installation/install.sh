
a2ensite smapp.conf # change for suitable .conf file.

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