<?php

trait ProxyOptionTrait
{
    private function setOptions(array $options = [])
    {
        $this->options = $options;
        $this->setDefaultOptions();
    }
    
    private function getOption(string $key)
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
