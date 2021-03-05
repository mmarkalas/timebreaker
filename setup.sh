#!/bin/sh

cp .env.example .env

docker-compose build --no-cache
docker-compose up -d

echo "$(tput setaf 2)Checking if Composer is done installing$(tput setaf 7)"

while : 
do
	check=`docker-compose exec composer sh -c "echo active" | grep active`

	if [ "$check" = "" ]
	then
	   echo "$(tput setaf 2)Composer is done!$(tput setaf 7)"
	   echo "Generate Key and Migrate"
	   docker-compose exec app sh -c "php artisan key:generate && php artisan migrate"
	   break
	fi
	echo "$(tput setaf 3)Not yet done$(tput setaf 7)"
  	
  	sleep 1
done
