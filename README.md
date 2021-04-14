# dockering-php-application
Dockering php application using php:apache docker image and mysql docker image

# To clone the source files
`git clone https://github.com/sureshvenkey/dockering-php-application.git`
`git clone https://github.com/sureshvenkey/dockering-smart.wiki.git`

## Installing docker on rhel8
* Docker can be installed by specifying the install_docker.sh shell script in user data during the ec2 installation. Check the output from /var/log/cloud-init-output.log
* To do the normal installation view the install_docker.sh shell script



## dockering-php-application with out swarm
[root@ip-172-31-3-145 /]# cd /  
[root@ip-172-31-3-145 /]# mkdir venkat  
[root@ip-172-31-3-145 /]# cd venkat  
[root@ip-172-31-3-145 venkat]# ls -lart /venkat  
-rwxrwxrwx.  1 root root   93 Apr  2 15:04 create_table.sql  
-rwxrwxrwx.  1 root root 1525 Apr  2 15:28 index.php  
-rwxrwxrwx.  1 root root   73 Apr  2 16:13 Dockerfile  
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
 docker swarm join --token SWMTKN-1-2mslmt9h0gyj9o1nithh0fz9pgl5jx6e2eak5tkjgismktbd46-e8tl43ha0nie4qbjnri51kerz 172.31.3.145:2377 --> run this on other docker nodes to join as worker nodes.  
To add a manager to this swarm, run 'docker swarm join-token manager' and follow the instructions. 
[root@ip-172-31-3-145 ~]# docker node ls  
[root@ip-172-31-3-145 ~]# docker system prune
[root@ip-172-31-3-145 ~]# docker rmi <images>

**Creating new docker images which includes the app files in myphpapache image and database and its tables in mysqldb**

[root@ip-172-31-3-145 ~]# cd /venkat/swarm/mysql_dockerfile  
[root@ip-172-31-3-145 mysql_dockerfile]# ls -lart   
-rwxr-xr-x. 1 root root 93 Apr  4 03:50 create_table.sql  
-rwxrwxrwx. 1 root root 92 Apr  4 05:24 Dockerfile  
[root@ip-172-31-3-145 mysql_dockerfile]# docker build -t mysqldb .  
[root@ip-172-31-3-145 mysql_dockerfile]# cd /venkat/swarm/myweb_dockerfile  
[root@ip-172-31-3-145 myweb_dockerfile]# ls -lart  
-rwxrwxrwx. 1 root root 1521 Apr  4 03:23 index.php  
-rwxrwxrwx. 1 root root  102 Apr  4 04:13 Dockerfile  
[root@ip-172-31-3-145 myweb_dockerfile]# docker build -t myphpapache .  
[root@ip-172-31-3-145 myweb_dockerfile]# docker images  
[root@ip-172-31-3-145 myweb_dockerfile]# cd ~  
[root@ip-172-31-3-145 ~]# docker service create --name myweb -p 8080:80 myphpapache    
[root@ip-172-31-3-145 ~]# docker service create --name mysql -p 3306:3306 mysqldb 
[root@ip-172-31-3-145 ~]# docker service ls  
[root@ip-172-31-3-145 ~]# docker service ps mysql  
[root@ip-172-31-3-145 ~]# docker service ps myweb  
