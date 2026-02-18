<?php

return function (): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $cfg = require __DIR__ . '/config.php';
        $d = $cfg['db'];
        $dsn = "mysql:host={$d['host']};dbname={$d['name']};charset=utf8mb4";
        $opts = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        if (!in_array($d['host'], ['localhost', '127.0.0.1'], true)) {
            $caPath = '/etc/ssl/certs/ca-certificates.crt';
            if (file_exists($caPath)) {
                $opts[PDO::MYSQL_ATTR_SSL_CA] = $caPath;
            }
            $opts[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }

        $pdo = new PDO($dsn, $d['user'], $d['pass'], $opts);
    }
    return $pdo;
};
