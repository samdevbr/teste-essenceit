docker-compose up -d app

echo "======================================="
echo "[Infrastructure]\n"

docker-compose exec app "./app/vendor/bin/phpunit --colors src/App/Infrastructure/Tests"

echo "======================================="
echo "[Quote Domain]\n"
docker-compose exec app "./app/vendor/bin/phpunit --colors src/App/Domain/Quote/Tests"
