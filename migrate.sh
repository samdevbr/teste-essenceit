echo "Waiting MySQL boot up..."
sleep 5
docker-compose exec mysql sh /mysql/scripts/migrate.sh
