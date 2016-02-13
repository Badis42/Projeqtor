# Dockerized Projeqtor

This Container is a project managment tool called Projeqtor

## Make It Short

You have to link this container with a database container (PostgreSQL or Mysql)
### Projeqtor with PostgreSQL

PostgreSQL Official Docker Image:
~~~~
$ docker run --name postgres -d \
    -e 'POSTGRES_USER=admin' \
    -e 'POSTGRES_PASSWORD=admin' \
       postgres
	   
$ docker run -d --link postgres:database -p 80:80 --name projeqtor troptop/projeqtor
~~~~

### Projeqtor with MySQL

MySQL Official Docker Image:

~~~~
$ docker run -d --name mysql \
    -e 'MYSQL_ROOT_PASSWORD=verybigsecretrootpassword' \
    -e 'MYSQL_DATABASE=projeqtor' \
    -e 'MYSQL_USER=admin' \
    -e 'MYSQL_PASSWORD=admin' \
    mysql:5.6
$ docker run -d --link mysql:database -p 80:80 --name projeqtor troptop/projeqtor
~~~~

