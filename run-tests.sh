echo "======================================="
echo "[Infrastructure]\n"

./src/vendor/bin/phpunit --colors src/App/Infrastructure/Tests

echo "======================================="
echo "[Quote Domain]\n"
./src/vendor/bin/phpunit --colors src/App/Domain/Quote/Tests
