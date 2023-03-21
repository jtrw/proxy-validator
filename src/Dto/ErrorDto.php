<?php

namespace Jtrw\ProxyValidator\Dto;

use Jtrw\ProxyValidator\Validator;

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
        
        $dto->proxyName = $fields[Validator::KEY_PROXY_STR] ?? "";
        $dto->message = $fields[Validator::KEY_MESSAGE] ?? "";
        $dto->statusCode = $fields[Validator::KEY_STATUS_CODE] ?? "";
        
        return $dto;
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            Validator::KEY_PROXY_STR   => $this->proxyName,
            Validator::KEY_MESSAGE     => $this->message,
            Validator::KEY_STATUS_CODE => $this->statusCode
        ];
    }
}
