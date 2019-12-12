#!/usr/bin/env bash

composer install --prefer-dist --optimize-autoloader

npm install

php bin/console assets:install

php bin/console d:d:c

yes | php bin/console d:m:m

yes | php bin/console doctrine:fix:load

php bin/console cache:clear --no-warmup

php bin/console cache:warmup

