<?php

namespace Jtrw\ProxyValidator;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Jtrw\ProxyValidator\Exception\ProxyParamException;
use Psr\Http\Message\ResponseInterface;

class ProxyValidator
{
    private const SUCCESS_STATUS_CODE = 200;
    
    public const KEY_PROXY_STR   = "proxy_name";
    public const KEY_MESSAGE     = "message";
    public const KEY_STATUS_CODE = "status_code";
    
    
    private ClientInterface $httpClient;
    private ?ProxyOptions $options;
    
    public function __construct(ClientInterface $client, ProxyOptions $options = null)
    {
        $this->httpClient = $client;
        $this->setOptions($options);
    }
    
    private function setOptions(ProxyOptions $options = null)
    {
        if (!$options) {
            $options = new ProxyOptions();
        }
        $this->options = $options;
    }
    
    public function validate(string $proxy): ProxyResponse
    {
        $errors = [];
        try {
            $proxyDto = $this->getProxyDto($proxy);
        } catch (ProxyParamException $exp) {
            $errors[static::KEY_PROXY_STR] = $proxy;
            $errors[static::KEY_MESSAGE] = $exp->getMessage();
            return new ProxyResponse(false, ErrorDto::fromArray($errors));
        }
        
        try {
            $httpResponse = $this->request($proxyDto);
        } catch (ClientException $exp) {
            $errors[static::KEY_PROXY_STR] = $proxy;
            $errors[static::KEY_MESSAGE] = $exp->getMessage();
            $errors[static::KEY_STATUS_CODE] = $exp->getResponse()->getStatusCode();
            return new ProxyResponse(false, ErrorDto::fromArray($errors));
        } catch (GuzzleException $exp) {
            $errors[static::KEY_PROXY_STR] = $proxy;
            $errors[static::KEY_MESSAGE] = $exp->getMessage();
            return new ProxyResponse(false, ErrorDto::fromArray($errors));
        }
        
        $statusCode = $httpResponse->getStatusCode();
        
        if ($httpResponse->getStatusCode() !== static::SUCCESS_STATUS_CODE) {
            $errors[static::KEY_PROXY_STR] = $proxy;
            $errors[static::KEY_STATUS_CODE] = $statusCode;
            return new ProxyResponse(false, ErrorDto::fromArray($errors));
        }
    
        return new ProxyResponse(true);
    }
    
    /**
     * @param string $proxy
     * @return ProxyDto
     * @throws ProxyParamException
     */
    private function getProxyDto(string $proxy): ProxyDto
    {
        $formatter = new ProxyFormatter($proxy);
        return $formatter->format();
    }
    
    /**
     * @param ProxyDto $proxyDto
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function request(ProxyDto $proxyDto): ResponseInterface
    {
        $proxyStr = $this->getProxyStr($proxyDto);
        
        return $this->httpClient->request("GET", $this->options->getOption(ProxyOptions::OPTIONS_KEY_TEST_HOST), [
            "proxy" => $proxyStr,
            'timeout' => $this->options->getOption(ProxyOptions::OPTIONS_KEY_TIMEOUT), // Response timeout
            'connect_timeout' => $this->options->getOption(ProxyOptions::OPTIONS_CONNECT_KEY_TIMEOUT), // Connection timeout
        ]);
    }
    
    /**
     * @param ProxyDto $proxyDto
     * @return string
     */
    private function getProxyStr(ProxyDto $proxyDto): string
    {
        return sprintf(
            "%s://%s:%s@%s:%s",
            $proxyDto->getType(),
            $proxyDto->getLogin(),
            $proxyDto->getPass(),
            $proxyDto->getHost(),
            $proxyDto->getPort()
        );
    }
}
