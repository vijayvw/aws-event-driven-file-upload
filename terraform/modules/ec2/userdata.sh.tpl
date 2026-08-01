#!/bin/bash
set -euxo pipefail

# Update packages
dnf update -y

# Install software
  dnf install -y \
    httpd \
    php \
    php-cli \
    php-json \
    php-mbstring \
    php-xml \
    php-curl \
    php-zip \
    git \
    unzip
# Enable Apache
systemctl enable httpd
systemctl start httpd

# Configure Composer for non-interactive root execution

export HOME=/root

export COMPOSER_HOME=/root/.composer

export COMPOSER_ALLOW_SUPERUSER=1

mkdir -p "$COMPOSER_HOME"

# Install Composer
cd /tmp

php -r "copy('https://getcomposer.org/installer','composer-setup.php');"

php composer-setup.php \
    --install-dir=/usr/local/bin \
    --filename=composer

rm composer-setup.php


# Clone project
cd /opt

git clone ${github_repo} app

# Copy PHP application
cp -r /opt/app/website/* /var/www/html/

cd /var/www/html

composer install --no-dev --optimize-autoloader

# Set Apache environment variables
cat <<EOF >/etc/httpd/conf.d/app-env.conf
SetEnv S3_BUCKET ${bucket_name}
SetEnv AWS_REGION us-east-1
EOF

# Set permissions
chown -R apache:apache /var/www/html
chmod -R 755 /var/www/html

systemctl restart httpd
