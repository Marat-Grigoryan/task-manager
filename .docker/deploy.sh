#!/bin/bash

# Install Composer dependencies
docker exec task-management composer install

# Run Laravel migrations
docker exec task-management php artisan migrate
