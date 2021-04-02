# dockering-php-application
Dockering php application using php:apache docker image and mysql docker image

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
