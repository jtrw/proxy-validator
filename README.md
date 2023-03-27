# Proxy Validator

# Simple Telegram Message

[![Phpunit](https://github.com/jtrw/proxy-validator/workflows/phpunit/badge.svg)](https://github.com/jtrw/proxy-validator/actions)
[![codecov](https://codecov.io/gh/jtrw/proxy-validator/branch/master/graph/badge.svg?token=UADT3RAW2A)](https://codecov.io/gh/jtrw/proxy-validator)
[![Latest Stable Version](http://poser.pugx.org/jtrw/proxy-validator/v)](https://packagist.org/packages/jtrw/proxy-validator)
[![Total Downloads](http://poser.pugx.org/jtrw/proxy-validator/downloads)](https://packagist.org/packages/jtrw/proxy-validator)
[![Latest Unstable Version](http://poser.pugx.org/jtrw/proxy-validator/v/unstable)](https://packagist.org/packages/jtrw/proxy-validator)
[![License](http://poser.pugx.org/jtrw/simple-telegram-message/license)](https://packagist.org/packages/jtrw/proxy-validator)
[![PHP Version Require](http://poser.pugx.org/jtrw/proxy-validator/require/php)](https://packagist.org/packages/jtrw/proxy-validator)

Example:

```php
use Jtrw\ProxyValidator\ProxyValidator;
use GuzzleHttp\Client;

$validator = new Validator(new Client());

$responseDto = $validator->validate("host:port:login:pass:type");

if ($responseDto->isValid()) {
 // Do something
}
if ($errorsDto = $responseDto->getErrors()) {
    echo $errorsDto->getMessage();
}

```
