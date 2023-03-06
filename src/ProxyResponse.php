<?php

namespace Jtrw\ProxyValidator;

class ProxyResponse
{
    private bool $isValid;
    private ErrorDto $errors;
    
    public function __construct(bool $isValid = false, array $errors = [])
    {
        $this->isValid = $isValid;
        $this->errors = ErrorDto::fromArray($errors);
    }
    
    public function isValid(): bool
    {
        return $this->isValid;
    }
    
    public function getErrors(): ErrorDto
    {
        return $this->errors;
    }
}
