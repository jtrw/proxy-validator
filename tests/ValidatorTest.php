<?php

namespace Jtrw\ProxyValidator\Tests;

use GuzzleHttp\Client;
use Jtrw\ProxyValidator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testFailedProxy()
    {
        $validator = new Validator(new Client());
        $proxyStr = "127.0.0.1:27701:user:pass:http";
        $response = $validator->validate($proxyStr);
        
        static::assertFalse($response->isValid());
    
        $errorsDto = $response->getErrors();
        
        static::assertEquals($proxyStr, $errorsDto->getProxyName());
        static::assertNotEmpty($errorsDto->getMessage());
    }
    
    public function testNotValidProxyStr()
    {
        $validator = new Validator(new Client());
        $proxyStr = "127.0.0.1";
        $response = $validator->validate($proxyStr);
    
        static::assertFalse($response->isValid());
    
        $errorsDto = $response->getErrors();
        
        static::assertEquals($errorsDto->getMessage(), "Port Not Found");
    }
}
