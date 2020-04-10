docker-compose up -d app

echo "======================================="
echo "[Infrastructure]"

docker-compose exec app ./vendor/bin/phpunit --colors App/Infrastructure/Tests

echo "======================================="
echo "[Quote Domain]"
docker-compose exec app ./vendor/bin/phpunit --colors App/Domain/Quote/Tests