# dockering-php-application
Dockering php application using php:apache docker image and mysql docker image

## Installing docker on rhel8
[root@ip-172-31-3-145 ~]# cat /etc/redhat-release  
Red Hat Enterprise Linux release 8.3 (Ootpa)  
[root@ip-172-31-3-145 ~]# dnf update  
[root@ip-172-31-3-145 ~]# dnf config-manager --add-repo=https://download.docker.com/linux/centos/docker-ce.repo --> Add the repo  
[root@ip-172-31-3-145 ~]# dnf repolist -v --> View the repo  
[root@ip-172-31-3-145 ~]# dnf list docker-ce --showduplicates | sort -r  
[root@ip-172-31-3-145 ~]# dnf install docker-ce-3:18.09.1-3.el7 --> Install latest version of docker  
[root@ip-172-31-3-145 ~]# systemctl disable firewalld  
[root@ip-172-31-3-145 ~]# systemctl enable --now docker  
[root@ip-172-31-3-145 ~]# systemctl start docker  
[root@ip-172-31-3-145 ~]# systemctl is-active docker  
[root@ip-172-31-3-145 ~]# docker --version  

## dockering-php-application with out swarm
[root@ip-172-31-3-145 /]# cd /  
[root@ip-172-31-3-145 /]# mkdir venkat  
[root@ip-172-31-3-145 /]# cd venkat  
[root@ip-172-31-3-145 venkat]# ls -lart /venkat  
total 8  
dr-xr-xr-x. 19 root root  250 Apr  2 14:51 ..  
-rwxrwxrwx.  1 root root   93 Apr  2 15:04 create_table.sql  
-rwxrwxrwx.  1 root root 1525 Apr  2 15:28 index.php  
-rwxrwxrwx.  1 root root   73 Apr  2 16:13 Dockerfile  
drwxr-xr-x.  2 root root   47 Apr  2 15:56 .  
[root@ip-172-31-3-145 venkat]# cat create_table.sql  
create database phonedb;  
use phonedb;  
create table emp(name varchar(16), phone varchar(16));  
[root@ip-172-31-3-145 venkat]#  
[root@ip-172-31-3-145 venkat]# cat Dockerfile  
FROM php:apache  
RUN docker-php-ext-install mysqli  
RUN apachectl restart  
[root@ip-172-31-3-145 venkat]# docker build -t myphpapache .  
[root@ip-172-31-3-145 venkat]# docker container prune  
[root@ip-172-31-3-145 venkat]# docker network create -d bridge mybridge  
[root@ip-172-31-3-145 venkat]# docker run -i -d --name myweb --network mybridge -p 8080:80 -v /venkat/:/var/www/html/ myphpapache  
[root@ip-172-31-3-145 venkat]# docker run -i -d --name mysql --network mybridge -p 3306:3306 -v /venkat/create_table.sql:/docker-entrypoint-initdb.d/create_table.sql -e MYSQL_ROOT_PASSWORD=mysql mysql  
[root@ip-172-31-3-145 venkat]# docker ps  

## dockering-php-application in swarm by creating new swarm
[root@ip-172-31-3-145 ~]# docker swarm init --advertise-addr 172.31.3.145  
Swarm initialized: current node (iwxjtiguuo8qbxrl66v7l9aox) is now a manager.  
To add a worker to this swarm, run the following command:  
 docker swarm join --token SWMTKN-1-2mslmt9h0gyj9o1nithh0fz9pgl5jx6e2eak5tkjgismktbd46-e8tl43ha0nie4qbjnri51kerz 172.31.3.145:2377  
To add a manager to this swarm, run 'docker swarm join-token manager' and follow the instructions.  
[root@ip-172-31-3-145 ~]#


