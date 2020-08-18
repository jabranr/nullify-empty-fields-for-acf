#!/usr/bin/env bash

cd /var/www/html

WPPATH=/var/www/html

echo "- Fix permissions";
echo "=====================================";
chown -R www-data:www-data $WPPATH

echo "- Install WP CLI";
echo "=====================================";
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
php $WPPATH/wp-cli.phar --info
chmod +x wp-cli.phar
mv $WPPATH/wp-cli.phar /usr/local/bin/wp

echo "- Install and activate required plugins";
echo "=====================================";
wp plugin install advanced-custom-fields --activate --path=$WPPATH --allow-root
wp plugin install acf-to-rest-api --activate --path=$WPPATH --allow-root
wp plugin activate nullify-empty-fields-for-acf --path=$WPPATH --allow-root

echo "- Add a development user";
echo "=====================================";
wp user create dev dev@admin.user --role=administrator --user_pass=password --path=$WPPATH --allow-root

echo "- Start apache";
echo "=====================================";
exec "apache2-foreground"
