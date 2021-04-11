#!/bin/bash
sudo cat /etc/redhat-release
sudo dnf update -y
sudo dnf config-manager --add-repo=https://download.docker.com/linux/centos/docker-ce.repo
sudo dnf repolist -v
sudo dnf list docker-ce
sudo dnf install docker-ce-3:18.09.1-3.el7
sudo systemctl disable firewalld
sudo systemctl enable --now docker
sudo systemctl start docker
sudo systemctl is-active docker
sudo docker --version
sudo curl -L "https://github.com/docker/compose/releases/download/1.23.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo docker-compose --version
