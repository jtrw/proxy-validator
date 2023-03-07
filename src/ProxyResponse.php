<?php

namespace Jtrw\ProxyValidator;

class ProxyResponse
{
    private bool $isValid;
    private ?ErrorDto $errors = null;
    
    public function __construct(bool $isValid = false, ErrorDto $errorDto = null)
    {
        $this->isValid = $isValid;
        $this->errors = $errorDto;
    }
    
    public function isValid(): bool
    {
        return $this->isValid;
    }
    
    public function getErrors(): ?ErrorDto
    {
        return $this->errors;
    }
}
