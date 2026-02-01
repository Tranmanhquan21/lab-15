<?php
/**
 * LAB 14 – Topic 3: Flash message (set_flash / get_flash)
 * LAB 15 – Topic 3: Ghi log (write_log)
 */
if (!function_exists('set_flash')) {
    function set_flash(string $key, string $message): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flash'][$key] = $message;
    }
}

if (!function_exists('get_flash')) {
    function get_flash(string $key): ?string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $msg = $_SESSION['flash'][$key] ?? null;
        if ($msg !== null) {
            unset($_SESSION['flash'][$key]);
        }
        return $msg;
    }
}

if (!function_exists('write_log')) {
    function write_log(string $message, string $level = 'INFO'): void {
        $logDir = dirname(__DIR__) . '/storage/logs';
        $logFile = $logDir . '/app.log';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        $line = '[' . date('Y-m-d H:i:s') . '] [' . $level . '] ' . $message . PHP_EOL;
        @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
    }
}
