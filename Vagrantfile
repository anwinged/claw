# -*- mode: ruby -*-
# vi: set ft=ruby :

# For installing ansible_local from pip on guest
Vagrant.require_version ">= 1.8.3"


Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/trusty64"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
  end

  config.vm.provision "ansible_local" do |ansible|
    ansible.playbook = "ansible/provision.yml"
  end

  config.vm.network "forwarded_port", guest: 80, host: 8000, auto_correct: true
  config.vm.network "forwarded_port", guest: 3306, host: 25566, auto_correct: true

end
