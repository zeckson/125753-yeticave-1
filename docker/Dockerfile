# Use an official Ubuntu 18.04
FROM ubuntu:18.04

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
# ADD .. /app

# Update everything
# Can we use several RUN commands here?
RUN apt-get -y update
RUN apt-get -y install nginx
RUN cd /etc/nginx/sites-available
COPY ./nginx.conf /etc/nginx/sites-available/yeticave.local

# Make port 80 available to the world outside this container
EXPOSE 80

# Define environment variable
ENV NAME World

STOPSIGNAL SIGTERM

CMD ["nginx", "-g", "daemon off;"]