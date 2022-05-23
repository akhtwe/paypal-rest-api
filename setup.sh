#!/bin/bash
eval "$(grep ^APP_NAME= .env)"
eval "$(grep ^HOST_PORT= .env)"
echo "Running you app : ${APP_NAME}"
file=.env
if [ ! -e "$file" ]; then
        echo ".env File does not exist"
else 
        echo ".env found in system ${APP_NAME}"
        if [ ! "$(docker ps -aq -f name=$APP_NAME)" ]; then
                docker-compose -f docker-compose.yml build 
                docker-compose -f docker-compose.yml up -d
                docker exec $APP_NAME bash
        else 
                echo "Docker container : ${APP_NAME} already exist."
                docker restart $APP_NAME"_DB"
                echo "Database is starting."
                docker restart $APP_NAME
                echo "App is starting."
                docker restart $APP_NAME"_PMA"
                echo "PhpMyAdmin is starting."
        fi
fi 
echo "Successfully completed!"
read -rn1