Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/jammy64"

	# CONFIGURE PORT FORWARDING
	config.vm.network "forwarded_port", guest: 80, host: 5000
	config.vm.network "forwarded_port", guest: 3306, host: 5001
	config.vm.network "forwarded_port", guest: 5432, host: 5002

	# INCREASE INSTANCE MEMORY
	config.vm.provider "virtualbox" do |vb|
		vb.memory = "256"
	end

	# SETUP MACHINE
	config.vm.provision "shell" do |s|
		s.path = "tools/vagrant/provision.sh"
	end

end
