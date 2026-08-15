#!/bin/bash
/usr/local/bin/php artisan migrate --force
/usr/local/bin/php artisan db:seed --force
/usr/local/bin/php artisan serve --host=0.0.0.0 --port=$PORT
