<?php
require_once __DIR__ . "/../vendor/autoload.php";

use App\Infrastructure\Http\Handler as HttpHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$httpHandler = new HttpHandler;
$httpHandler->handle();
