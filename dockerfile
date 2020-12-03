FROM ubuntu:latest

# Installing packages
RUN apt-get update -y
RUN apt-get upgrade -y
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install apache2
RUN apt-get install -y gnupg2
RUN apt-get install -y lsb-release && apt-get clean all
RUN apt-get -y install wget ca-certificates
RUN wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -
RUN echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" >> /etc/apt/sources.list.d/pgdg.list
RUN apt-get update -y
RUN apt-get install -y postgresql postgresql-contrib
RUN apt-get install -y software-properties-common
RUN add-apt-repository -y ppa:ondrej/php
RUN apt-get update -y
RUN apt install -y php7.0 php7.0-cli php7.0-common php7.0-mbstring php7.0-intl php7.0-xml php7.0-mysql php7.0-mcrypt php7.0-pgsql

USER postgres

# Create a PostgreSQL role named ``docker`` with ``docker`` as the password and
# then create a database `docker` owned by the ``docker`` role.
# Note: here we use ``&&\`` to run commands one after the other - the ``\``
#       allows the RUN command to span multiple lines.
RUN    /etc/init.d/postgresql start &&\
    psql --command "CREATE USER admin WITH SUPERUSER PASSWORD 'Inicio.123';" &&\
    createdb -O admin dipaac

# Adjust PostgreSQL configuration so that remote connections to the
# database are possible.
RUN echo "host all  all    0.0.0.0/0  md5" >> /etc/postgresql/12/main/pg_hba.conf

# And add ``listen_addresses`` to ``/etc/postgresql/9.3/main/postgresql.conf``
RUN echo "listen_addresses='*'" >> /etc/postgresql/12/main/postgresql.conf

USER root

# COPY ["./project", "/var/www/html/dippac"]

EXPOSE 80 5432

ENTRYPOINT service apache2 start && phpenmod pdo_pgsql && service apache2 start && service postgresql start && /bin/bash