<?php

namespace Jtrw\ProxyValidator;

class ProxyOptions
{
    public const OPTIONS_KEY_TIMEOUT         = "timeout";
    public const OPTIONS_CONNECT_KEY_TIMEOUT = "connect_timeout";
    public const OPTIONS_KEY_TEST_HOST       = "host";
    
    private const DEFAULT_TEST_HOST = "https://google.com";
    private const TIMEOUT_DEFAULT_VALUE         = 3;
    private const CONNECT_TIMEOUT_DEFAULT_VALUE = 3;
    
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }
    
    private function setOptions(array $options = [])
    {
        $this->options = $options;
        $this->setDefaultOptions();
    }
    
    public function getOption(string $key)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }
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
}
