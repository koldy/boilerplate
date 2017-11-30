#!/bin/bash

echo "Provisioning virtual machine for development with Koldy Framework..."

# SWAP file:
fallocate -l 256M /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
cp /etc/fstab /etc/fstab.bak
echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab

sysctl vm.swappiness=10
echo 'vm.swappiness=10' | sudo tee -a /etc/sysctl.conf

sysctl vm.vfs_cache_pressure=50
echo 'vm.vfs_cache_pressure=50' | sudo tee -a /etc/sysctl.conf


apt-get update > /dev/null
apt-get upgrade > /dev/null

echo "Configuring UTF-8 locale..."
apt-get install -y language-pack-en-base > /dev/null && export LC_ALL=en_US.UTF-8 && export LANG=en_US.UTF-8

echo "Installing tools..."
apt-get install htop discus zip software-properties-common python-software-properties -y

echo "Installing Git"
apt-get install git -y > /dev/null

echo "Installing Nginx"
apt-get install nginx -y > /dev/null
cp /vagrant/tools/vagrant/etc/nginx/sites-available/* /etc/nginx/sites-available

echo "Installing Memcache"
apt-get install memcached -y > /dev/null

echo "Installing PHP 7.1"
add-apt-repository ppa:ondrej/php -y
apt-get update > /dev/null
apt-get upgrade -y > /dev/null
apt-get install php7.1-fpm php7.1-cli php7.1-common php7.1-mysql php7.1-mbstring php7.1-pgsql php7.1-sqlite php7.1-intl php7.1-gd php7.1-curl php7.1-zip php7.1-xml php7.1-memcached php7.1-bcmath php7.1-xdebug -y > /dev/null
cp /vagrant/tools/vagrant/etc/php/7.1/fpm/php.ini /etc/php/7.1/fpm/php.ini
cp /vagrant/tools/vagrant/etc/php/7.1/fpm/pool.d/www.conf /etc/php/7.1/fpm/pool.d/www.conf

echo "Installing Postgres"
sudo sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" >> /etc/apt/sources.list.d/pgdg.list'
wget -q https://www.postgresql.org/media/keys/ACCC4CF8.asc -O - | sudo apt-key add -
apt-get update > /dev/null
apt-get install postgresql-10 postgresql-contrib -y > /dev/null

sudo -u postgres psql -c "DROP DATABASE IF EXISTS vagrant;"
sudo -u postgres psql -c "CREATE USER vagrant WITH PASSWORD 'vagrant';"
sudo -u postgres psql -c "CREATE DATABASE vagrant OWNER vagrant;"
sudo -u postgres psql -c "ALTER USER vagrant WITH superuser;"
cp /vagrant/tools/vagrant/etc/postgresql/10/main/*.conf /etc/postgresql/10/main/

echo "Running FINALS..."
service nginx restart
service php7.1-fpm restart
service postgresql restart

echo "Done."