docker-compose up -d mysql
docker-compose exec mysql "mysql -uroot -proot < /mysql/scripts/db.sql"
