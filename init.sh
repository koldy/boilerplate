#!/bin/bash

vagrant up
vagrant ssh -c "cd /vagrant && ./init-dev-after-clone.sh"

echo "VM is started, you may now open http://localhost:5000"