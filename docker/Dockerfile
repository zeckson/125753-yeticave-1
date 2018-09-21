# Use an official Ubuntu 18.04
FROM ubuntu:18.04

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
# ADD .. /app

# Update everything
RUN apt-get -y update
# Install nginx
RUN apt-get -y install nginx
VOLUME ./nginx.conf /etc/nginx/sites-available/yeticave.local

# Make port 80 available to the world outside this container
EXPOSE 80

# Define environment variable
ENV NAME World

STOPSIGNAL SIGTERM

CMD ["nginx", "-g", "daemon off;"]