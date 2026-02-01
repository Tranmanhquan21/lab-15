<?php
/**
 * LAB 15 – Topic 1: Chọn config theo môi trường (config.local / config.prod)
 */
$env = $_ENV['APP_ENV'] ?? 'local';
$configFile = __DIR__ . '/config.' . $env . '.php';
if (!is_file($configFile)) {
    $configFile = __DIR__ . '/config.local.php';
}
$config = require $configFile;
if (isset($config['display_errors'])) {
    ini_set('display_errors', (string)(int)$config['display_errors']);
}
return $config;
