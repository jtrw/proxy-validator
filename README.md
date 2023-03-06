# Proxy Validator

Example:

```php
use Jtrw\ProxyValidator\ProxyValidator;

$validator = new ProxyValidator(new Client());

$responseDto = $validator->validate("host:port:login:pass:type");

if ($responseDto->isValid()) {
 // Do something
}
if ($errorsDto = $responseDto->getErrors()) {
    echo $errorsDto->getMessage();
}

```
