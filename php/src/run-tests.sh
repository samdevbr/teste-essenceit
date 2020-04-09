echo "======================================="
echo "[Infrastructure]\n"

./vendor/bin/phpunit --colors App/Infrastructure/Tests

echo "======================================="
echo "[Quote Domain]\n"
./vendor/bin/phpunit --colors App/Domain/Quote/Tests
