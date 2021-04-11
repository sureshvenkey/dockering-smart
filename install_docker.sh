cat /etc/redhat-release
dnf update -y
dnf config-manager --add-repo=https://download.docker.com/linux/centos/docker-ce.repo
dnf repolist -v
dnf list docker-ce
dnf install docker-ce-3:18.09.1-3.el7
systemctl disable firewalld
systemctl enable --now docker
systemctl start docker
systemctl is-active docker
docker --version
curl -L "https://github.com/docker/compose/releases/download/1.23.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
docker-compose --version
