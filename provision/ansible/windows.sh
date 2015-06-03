#!/usr/bin/env bash

base_path=$1
src_path=$2

#sudo apt-get -y install epel-release
sudo apt-get -y install ansible

# Setup Ansible for Local Use and Run. Copy needed to make it compatible with Windows filesystem.
sudo cp ${src_path}provision/ansible/inventories/dev /etc/ansible/hosts -f
sudo chmod 666 /etc/ansible/hosts
cat ${src_path}provision/ansible/files/authorized_keys.pub >> /home/vagrant/.ssh/authorized_keys

# Run playbook
PYTHONUNBUFFERED=1 ansible-playbook ${src_path}provision/ansible/playbook.yml -e cpd=internal -e base_path=$base_path -e src_path=$src_path --connection=local
