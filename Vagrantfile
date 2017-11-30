Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/trusty64"

	# CONFIGURE PORT FORWARDING
	config.vm.network "forwarded_port", guest: 80, host: 5000
	config.vm.network "forwarded_port", guest: 3306, host: 5101
	config.vm.network "forwarded_port", guest: 5432, host: 5102

	# CONFIGURE NETWORKING
	# config.vm.network "private_network", ip: "10.10.10.2"

	# INCREASE INSTANCE MEMORY
	config.vm.provider "virtualbox" do |vb|
		vb.memory = "128"
	end

	# SETUP MACHINE
	config.vm.provision "shell" do |s|
		s.path = "tools/vagrant/provision.sh"
	end

end