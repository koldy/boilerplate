#!/bin/bash

echo "Provisioning virtual machine for development with Koldy Framework..."

# SWAP file:
fallocate -l 512M /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
cp /etc/fstab /etc/fstab.bak
echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab

sysctl vm.swappiness=10
echo 'vm.swappiness=10' | sudo tee -a /etc/sysctl.conf

sysctl vm.vfs_cache_pressure=50
echo 'vm.vfs_cache_pressure=50' | sudo tee -a /etc/sysctl.conf

apt-get update
apt-get upgrade

echo "Configuring UTF-8 locale..."
apt install -y language-pack-en-base && export LC_ALL=en_US.UTF-8 && export LANG=en_US.UTF-8

echo "Installing tools..."
apt install git -y
apt install htop -y
apt install discus -y
apt install zip -y
apt install unzip -y
apt install ntp -y
apt install software-properties-common -y
apt install inkscape -y
apt install net-tools -y

echo "Installing Git"
apt-get install git -y > /dev/null

# Prepare Logs folders for easier troubleshooting
rm -rf /vagrant/logs
mkdir /vagrant/logs
chmod 0777 /vagrant/logs

echo "Installing Nginx"
apt-get install nginx -y > /dev/null
sed -i 's#/var/log/nginx/#/vagrant/logs/nginx.#g' /etc/nginx/nginx.conf
sed -i 's#sendfile on;#sendfile off;#g' /etc/nginx/nginx.conf
cp /vagrant/tools/vagrant/etc/nginx/sites-available/* /etc/nginx/sites-available
service nginx restart

echo "Installing Memcache"
apt-get install memcached -y > /dev/null

echo "Installing PHP 8.1"
apt update
LC_ALL=en_US.UTF-8 apt install php8.1-fpm php8.1-cli php8.1-common php8.1-mbstring php8.1-pgsql php8.1-intl php8.1-gd php8.1-imagick php8.1-curl php8.1-zip php8.1-xml php8.1-memcached php8.1-bcmath php-xdebug -y

VAGRANT_USER="user = $(stat -c %U /vagrant)"
VAGRANT_GROUP="group = $(stat -c %U /vagrant)"

sed -i 's#\;catch_workers_output = yes#catch_workers_output = yes#g' /etc/php/8.1/fpm/pool.d/www.conf
sed -i 's#user = www-data#'"$VAGRANT_USER"'#g' /etc/php/8.1/fpm/pool.d/www.conf
sed -i 's#group = www-data#'"$VAGRANT_GROUP"'#g' /etc/php/8.1/fpm/pool.d/www.conf
sed -i 's#\;php_admin_flag\[log_errors\] = on#php_admin_flag\[log_errors\] = on#g' /etc/php/8.1/fpm/pool.d/www.conf
sed -i 's#post_max_size = 8M#post_max_size = 32M#g' /etc/php/8.1/fpm/php.ini
sed -i 's#upload_max_filesize = 2M#upload_max_filesize = 32M#g' /etc/php/8.1/fpm/php.ini

touch /vagrant/logs/php.error.log
chmod -R 0777 /vagrant/logs/*
service php8.1-fpm restart

echo "Installing Postgres"
apt install postgresql-14 postgresql-client-14 -y

sudo -u postgres psql -c "DROP DATABASE IF EXISTS vagrant;"
sudo -u postgres psql -c "CREATE USER vagrant WITH PASSWORD 'vagrant';"
sudo -u postgres psql -c "CREATE DATABASE vagrant OWNER vagrant;"
sudo -u postgres psql -c "ALTER USER vagrant WITH superuser;"
sudo -u postgres psql vagrant < /vagrant/tools/admin.stage.sql

echo "host    all             all             0.0.0.0/0               trust" >> /etc/postgresql/14/main/pg_hba.conf
sed -i "s|#listen_addresses = 'localhost'|listen_addresses = '*'|g" /etc/postgresql/14/main/postgresql.conf

service postgresql restart
echo "Postgres installed"


echo "Installing MariaDB"
sh -c 'apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y mariadb-server'

mysql -u root -e "CREATE USER 'root'@'%' IDENTIFIED BY 'root'" mysql
mysql -u root -e "GRANT ALL ON *.* TO 'root'@'%'" mysql
mysql -u root -e "SET PASSWORD FOR 'root'@'%' = PASSWORD('root')" mysql

mysql -u root -e "CREATE USER 'root'@'localhost' IDENTIFIED BY 'root'" mysql
mysql -u root -e "GRANT ALL ON *.* TO 'root'@'localhost'" mysql
mysql -u root -e "SET PASSWORD FOR 'root'@'localhost' = PASSWORD('root')" mysql

mysql -u root -e "CREATE USER 'root'@'127.0.0.1' IDENTIFIED BY 'root'" mysql
mysql -u root -e "GRANT ALL ON *.* TO 'root'@'127.0.0.1'" mysql
mysql -u root -e "SET PASSWORD FOR 'root'@'127.0.0.1' = PASSWORD('root')" mysql

mysql -u root -e "CREATE USER 'vagrant'@'%' IDENTIFIED BY 'vagrant'" mysql
mysql -u root -e "GRANT ALL ON *.* TO 'vagrant'@'%'" mysql
mysql -u root -e "SET PASSWORD FOR 'vagrant'@'%' = PASSWORD('vagrant')" mysql

mysql -u root -e "CREATE USER 'vagrant'@'127.0.0.1' IDENTIFIED BY 'vagrant'" mysql
mysql -u root -e "GRANT ALL ON *.* TO 'vagrant'@'127.0.0.1'" mysql
mysql -u root -e "SET PASSWORD FOR 'vagrant'@'127.0.0.1' = PASSWORD('vagrant')" mysql

mysql -u root -e "CREATE USER 'vagrant'@'localhost' IDENTIFIED BY 'vagrant'" mysql
mysql -u root -e "GRANT ALL ON *.* TO 'vagrant'@'localhost'" mysql
mysql -u root -e "SET PASSWORD FOR 'vagrant'@'localhost' = PASSWORD('vagrant')" mysql

mysql -u root -e "FLUSH PRIVILEGES"
sed -i "s|= 127.0.0.1|= 0.0.0.0|g" /etc/mysql/mariadb.conf.d/50-server.cnf
mysql -u root -proot -e "CREATE DATABASE vagrant CHARACTER SET utf8 COLLATE utf8_general_ci"
service mysql restart

echo "Done provisioning Vagrant machine"
