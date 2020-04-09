<?php
require_once __DIR__ . "/../vendor/autoload.php";

use App\Infrastructure\Http\Handler as HttpHandler;

$httpHandler = new HttpHandler;

$httpHandler->handle();
