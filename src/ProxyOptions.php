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
    
    private array $options;
    
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }
    
    /**
     * @param array $options
     * @return void
     */
    private function setOptions(array $options = []): void
    {
        $this->options = $options;
        $this->setDefaultOptions();
    }
    
    /**
     * @param string $key
     * @return mixed|void
     */
    public function getOption(string $key)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }
    }
    
    /**
     * @return void
     */
    private function setDefaultOptions(): void
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
