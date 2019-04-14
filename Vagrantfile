# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/bionic64"
  config.vm.hostname = 'bionic'
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.synced_folder ".", "/vagrant", :owner => 'www-data',
    :group => 'vagrant', :mount_options => ['dmode=775', 'fmode=775']
  config.vm.provision "ansible_local" do |ansible|
    ansible.playbook = "ansible/ubuntu/vagrant_playbook.yml"
  end
end
