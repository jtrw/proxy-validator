<?php

namespace Jtrw\ProxyValidator;

use Jtrw\ProxyValidator\Dto\ErrorDto;

class ProxyResponse
{
    private bool $isValid;
    private ?ErrorDto $errors;
    
    /**
     * @param bool $isValid
     * @param ErrorDto|null $errorDto
     */
    public function __construct(bool $isValid = false, ErrorDto $errorDto = null)
    {
        $this->isValid = $isValid;
        $this->errors = $errorDto;
    }
    
    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }
    
    /**
     * @return ErrorDto|null
     */
    public function getErrors(): ?ErrorDto
    {
        return $this->errors;
    }
}
