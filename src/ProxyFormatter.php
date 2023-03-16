<?php

namespace Jtrw\ProxyValidator;

use Jtrw\ProxyValidator\Dto\ProxyDto;
use Jtrw\ProxyValidator\Exception\ProxyParamException;

class ProxyFormatter
{
    private const SEPARATOR = ":";
    
    private const HOST_INDEX = 0;
    private const PORT_INDEX = 1;
    private const LOGIN_INDEX = 2;
    private const PASS_INDEX = 3;
    private const TYPE_INDEX = 4;
    
    private string $proxy;
    
    public function __construct(string $proxy)
    {
        $this->proxy = $proxy;
    }
    
    public function format(string $format = null): ProxyDto
    {
        if (!$format) {
            $proxyData = explode(static::SEPARATOR, $this->proxy);
        }
        
        $host = $proxyData[self::HOST_INDEX] ?? null;
        
        if (!$host) {
            throw new ProxyParamException("Host Not Found");
        }
    
        $port = $proxyData[self::PORT_INDEX] ?? null;
    
        if (!$port) {
            throw new ProxyParamException("Port Not Found");
        }
    
        $login = $proxyData[self::LOGIN_INDEX] ?? null;
    
        if (!$login) {
            throw new ProxyParamException("Login Not Found");
        }
    
        $pass = $proxyData[self::PASS_INDEX] ?? null;
    
        if (!$pass) {
            throw new ProxyParamException("Pass Not Found");
        }
    
        $type = $proxyData[self::TYPE_INDEX] ?? null;
    
        if (!$type) {
            throw new ProxyParamException("Type Not Found");
        }
    
        return new ProxyDto($host, $port, $login, $pass, $type);
    }
}
