<?php
require_once dirname(__DIR__) . "/vendor/autoload.php";

try {
    $dsn =
        "pgsql:host=" .
        getenv("DB_HOST") .
        ";port=" .
        getenv("DB_PORT") .
        ";dbname=" .
        getenv("DB_NAME");
    $pdo = new PDO($dsn, getenv("DB_USER"), getenv("DB_PASS"), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
