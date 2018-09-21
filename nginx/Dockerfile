# Use an official Ubuntu 18.04
FROM ubuntu:18.04

# Set the working directory to /code
WORKDIR /code

# Update everything
RUN apt-get -y update
# Install nginx
RUN apt-get -y install nginx

# Define mountable directories.
VOLUME /etc/nginx/sites-enabled
VOLUME /etc/nginx/conf.d
VOLUME /etc/nginx/certs
VOLUME /var/log/nginx
VOLUME /var/www/html

# Make port 80 and 443 available to the world outside this container
EXPOSE 80
EXPOSE 443

# Define environment variable
ENV NAME World

STOPSIGNAL SIGTERM

CMD ["nginx", "-g", "daemon off;"]