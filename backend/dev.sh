if [ -f .env ]; then
  export $(cat .env)
fi

docker build . --tag third-music-api
docker run \
  -it --rm \
  --name third-music-api-dev \
  -p 3000:80 \
  -v $(pwd)/src:/var/www/html/ \
  -v $(pwd)/files:/var/www/html/files \
  --network mariadb \
  -e MYSQL_HOST=${MYSQL_HOST} \
  -e MYSQL_USER=${MYSQL_USER} \
  -e MYSQL_PASS=${MYSQL_PASS} \
  -e MYSQL_DB=${MYSQL_DB} \
  third-music-api
