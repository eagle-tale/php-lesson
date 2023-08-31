<?php
class Config {
    static private string $environment = 'production';

    static public function getEnvironment() {
        return self::$environment;
    }
}