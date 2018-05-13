<?php

namespace Monkedia\Test\Config;

class Config
{
    protected $_config;

    protected $_auth;

    /**
      * Parse Json Config File.
      */
    public function __construct($type = '') {
        $jsonStr = file_get_contents(dirname(__FILE__) . '/_config.json');
        $this->_config = json_decode($jsonStr);
        $this->_auth = $this->_config->database;
    }

    public function getDbType() {
        return $this->_auth->type;
    }
    public function getDbUser() {
        return $this->_auth->user;
    }

    public function getDbHost() {
        return $this->_auth->host;
    }

    public function getDbName() {
        return $this->_auth->name;
    }

    public function getDbPass() {
        return $this->_auth->password;
    }

    public function getUrl() {
        return $this->_config->url;
    }

    public function getBaseDir()
    {
        return $this->_config->base_dir;
    }
}
