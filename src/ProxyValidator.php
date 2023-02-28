<?php

namespace App\Common\Application\Proxy;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class ProxyValidator
{
    private const SEPARATOR = ":";
    private const MASK = "";
    private const DEFAULT_TEST_HOST = "https://google.com";
    
    private const SUCCESS_STATUS_CODE = 200;
    
    private const HOST_INDEX = 0;
    private const PORT_INDEX = 1;
    private const LOGIN_INDEX = 2;
    private const PASS_INDEX = 3;
    private const TYPE_INDEX = 4;
    
    private const KEY_PROXY_STR   = "proxy_name";
    private const KEY_MESSAGE     = "message";
    private const KEY_STATUS_CODE = "status_code";
    
    private const OPTIONS_KEY_TIMEOUT         = "timeout";
    private const OPTIONS_CONNECT_KEY_TIMEOUT = "connect_timeout";
    private const OPTIONS_KEY_TEST_HOST = "host";
    
    private const TIMEOUT_DEFAULT_VALUE         = 3;
    private const CONNECT_TIMEOUT_DEFAULT_VALUE = 3;
    
    private ClientInterface $httpClient;
    private array $options = [];
    
    public function __construct(ClientInterface $client, array $options = [])
    {
        $this->httpClient = $client;
        $this->setOptions($options);
    }
    
    private function setOptions(array $options = [])
    {
        $this->options = $options;
        $this->setDefaultOptions();
    }
    
    private function setDefaultOptions()
    {
        if (!isset($this->options[static::OPTIONS_KEY_TIMEOUT])) {
            $this->options[static::OPTIONS_KEY_TIMEOUT] = static::TIMEOUT_DEFAULT_VALUE;
        }
    
        if (!isset($this->options[static::OPTIONS_CONNECT_KEY_TIMEOUT])) {
            $this->options[static::OPTIONS_CONNECT_KEY_TIMEOUT] = static::CONNECT_TIMEOUT_DEFAULT_VALUE;
        }
        
        if (!isset($this->options[static::OPTIONS_KEY_TEST_HOST])) {
            $this->options[static::OPTIONS_KEY_TEST_HOST] = static::DEFAULT_TEST_HOST;
        }
    }
    
    public function validate(string $proxy): ProxyResponse
    {
        $errors = [];
        try {
            $proxyDto = $this->getProxyDto($proxy);
        } catch (ProxyParamException $exp) {
            $errors[static::KEY_PROXY_STR] = $proxy;
            $errors[static::KEY_MESSAGE] = $exp->getMessage();
            return new ProxyResponse(false, $errors);
        }
        
        $proxyStr = sprintf(
            "%s://%s:%s@%s:%s",
            $proxyDto->getType(),
            $proxyDto->getLogin(),
            $proxyDto->getPass(),
            $proxyDto->getHost(),
            $proxyDto->getPort()
        );
        
        try {
            $httpResponse = $this->httpClient->request("GET", $this->getOption(static::OPTIONS_KEY_TEST_HOST), [
                "proxy" => $proxyStr,
                'timeout' => $this->getOption(static::OPTIONS_KEY_TIMEOUT), // Response timeout
                'connect_timeout' => $this->getOption(static::OPTIONS_CONNECT_KEY_TIMEOUT), // Connection timeout
            ]);
        } catch (ClientException $exp) {
            $errors[static::KEY_PROXY_STR] = $proxy;
            $errors[static::KEY_MESSAGE] = $exp->getMessage();
            $errors[static::KEY_STATUS_CODE] = $exp->getResponse()->getStatusCode();
            return new ProxyResponse(false, $errors);
        } catch (GuzzleException $exp) {
            $errors[static::KEY_PROXY_STR] = $proxy;
            $errors[static::KEY_MESSAGE] = $exp->getMessage();
            return new ProxyResponse(false, $errors);
        }
        
        $statusCode = $httpResponse->getStatusCode();
        
        if ($httpResponse->getStatusCode() !== static::SUCCESS_STATUS_CODE) {
            $errors[static::KEY_PROXY_STR] = $proxy;
            $errors[static::KEY_STATUS_CODE] = $statusCode;
            return new ProxyResponse(false, $errors);
        }
    
        return new ProxyResponse(true);
    }
    
    private function getOption(string $key)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }
    }
    
    private function getProxyDto(string $proxy): ProxyDto
    {
        $proxyData = explode(static::SEPARATOR, $proxy);
    
        $host = $proxyData[self::HOST_INDEX] ?? throw new ProxyParamException("Host Not Found");
        $port = $proxyData[self::PORT_INDEX] ?? throw new ProxyParamException("Port Not Found");
        $login = $proxyData[self::LOGIN_INDEX] ?? throw new ProxyParamException("Login Not Found");
        $pass = $proxyData[self::PASS_INDEX] ?? throw new ProxyParamException("Pass Not Found");
        $type = $proxyData[self::TYPE_INDEX] ?? throw new ProxyParamException("Type Not Found");
        
        return new ProxyDto($host, $port, $login, $pass, $type);
    }
}
