Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/bionic64"

	# CONFIGURE PORT FORWARDING
	config.vm.network "forwarded_port", guest: 80, host: 5000
	config.vm.network "forwarded_port", guest: 3306, host: 5001
	config.vm.network "forwarded_port", guest: 5432, host: 5002

	# CONFIGURE NETWORKING
	# config.vm.network "private_network", ip: "10.10.10.2"

	# INCREASE INSTANCE MEMORY
	config.vm.provider "virtualbox" do |vb|
		vb.memory = "256"
	end

	# SETUP MACHINE
	config.vm.provision "shell" do |s|
		s.path = "tools/vagrant/provision.sh"
	end

	config.trigger.after :up do |trigger|
    trigger.name = "Nginx and PHP7.2-FPM started"
    trigger.info = "Trigger to start Nginx and PHP7.2-FPM after boot"
    trigger.run_remote = {inline: "service php7.2-fpm start && service nginx start"}
  end

end
