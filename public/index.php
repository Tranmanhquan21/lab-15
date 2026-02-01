<?php
/**
 * LAB 14 & 15 – Front controller
 * Lab 15 Topic 3: Ghi log lỗi kết nối DB
 */
error_reporting(E_ALL);
$baseDir = dirname(__DIR__);
require_once $baseDir . '/app/helpers.php';
$config = require $baseDir . '/config/config.php';

try {
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['db_host'], $config['db_name'], $config['db_charset']);
    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    write_log('DB connection error: ' . $e->getMessage(), 'ERROR');
    http_response_code(500);
    echo 'Lỗi kết nối cơ sở dữ liệu. Xem storage/logs/app.log.';
    exit;
}

require_once $baseDir . '/app/Product.php';
require_once $baseDir . '/app/ProductController.php';

$model = new Product($pdo);
$controller = new ProductController($model, $config);

$action = $_GET['action'] ?? 'index';
if ($action === 'create') {
    $controller->createForm();
} elseif ($action === 'store') {
    $controller->store();
} elseif ($action === 'edit') {
    $controller->editForm();
} elseif ($action === 'update') {
    $controller->update();
} elseif ($action === 'delete') {
    $controller->delete();
} elseif ($action === 'show') {
    $controller->show();
} else {
    $controller->index();
}
