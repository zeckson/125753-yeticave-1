# Use an official Ubuntu 18.04
FROM ubuntu:18.04

# Update everything
RUN apt-get -y update
# Install nginx
RUN apt-get -y install nginx

# Make port 80 and 443 available to the world outside this container
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
