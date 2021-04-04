# mysql image for php appplication with phonedb database and emp table created using init entrypoint.
FROM mysql
COPY create_table.sql /docker-entrypoint-initdb.d/
ENV MYSQL_ROOT_PASSWORD=mysql
