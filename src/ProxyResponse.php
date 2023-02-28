<?php

namespace App\Common\Application\Proxy;

class ProxyResponse
{
    private bool $isValid;
    private array $errors;
    
    public function __construct(bool $isValid = false, array $errors = [])
    {
        $this->isValid = $isValid;
        $this->errors = $errors;
    }
    
    public function isValid(): bool
    {
        return $this->isValid;
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
}
