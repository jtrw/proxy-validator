<?php

namespace Jtrw\ProxyValidator;

class ErrorDto
{
    private string $proxyName;
    private string $message;
    private string $statusCode;
    
    public function getProxyName(): string
    {
        return $this->proxyName;
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
    
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }
    
    public static function fromArray(array $fields): static
    {
        $dto = new self();
        
        $dto->proxyName = $fields[ProxyValidator::KEY_PROXY_STR] ?? "";
        $dto->message = $fields[ProxyValidator::KEY_MESSAGE] ?? "";
        $dto->statusCode = $fields[ProxyValidator::KEY_STATUS_CODE] ?? "";
        
        return $dto;
    }
    
    public function toArray(): array
    {
        return [
            ProxyValidator::KEY_PROXY_STR => $this->proxyName,
            ProxyValidator::KEY_MESSAGE => $this->message,
            ProxyValidator::KEY_STATUS_CODE => $this->statusCode
        ];
    }
    
    
}
