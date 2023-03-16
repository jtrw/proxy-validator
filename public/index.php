<?php

include_once __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;
use Jtrw\ProxyValidator\Validator;

$validator = new Validator(new Client());
$response = $validator->validate("127.0.0.1:27701:user:pass:http");

if (!$response->isValid()) {
    print_r($response->getErrors()->toArray());
}
