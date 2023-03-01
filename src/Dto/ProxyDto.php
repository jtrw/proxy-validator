<?php

namespace Jtrw\ProxyValidator;

class ProxyDto
{
    private string $host;
    private string $port;
    private string $login;
    private string $pass;
    private string $type;
    
    public function __construct(
        string $host,
        string $port,
        string $login,
        string $pass,
        string $type
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->login = $login;
        $this->pass = $pass;
        $this->type = $type;
    }
    
    public function getHost(): string
    {
        return $this->host;
    }
    
    public function getPort(): string
    {
        return $this->port;
    }
    
    public function getLogin(): string
    {
        return $this->login;
    }
    
    public function getPass(): string
    {
        return $this->pass;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
}
