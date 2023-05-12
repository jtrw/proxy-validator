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
    
    /**
     * @param string $proxy
     */
    public function __construct(string $proxy)
    {
        $this->proxy = $proxy;
    }
    
    /**
     * @param string|null $format
     * @return ProxyDto
     * @throws ProxyParamException
     */
    public function format(string $format = null): ProxyDto
    {
        if (!$format) {
            $proxyData = explode(static::SEPARATOR, $this->proxy);
        }
    
        $host = $proxyData[self::HOST_INDEX] ?? throw new ProxyParamException("Host Not Found"); //New comment for check code style comment long
        $port = $proxyData[self::PORT_INDEX] ?? throw new ProxyParamException("Port Not Found");
        $login = $proxyData[self::LOGIN_INDEX] ?? throw new ProxyParamException("Login Not Found");
        $pass = $proxyData[self::PASS_INDEX] ?? throw new ProxyParamException("Pass Not Found");
        $type = $proxyData[self::TYPE_INDEX] ?? throw new ProxyParamException("Type Not Found");
    
        return new ProxyDto($host, $port, $login, $pass, $type);
    }
}
