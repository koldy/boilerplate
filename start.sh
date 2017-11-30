#!/bin/bash

vagrant up
vagrant ssh -c "cd /vagrant && php composer.phar install && php composer.phar update"

echo "VM is started, you may now open http://localhost:5000"