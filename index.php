<?php
/**
 * Root index.php
 *
 * This file forwards all requests to public/index.php
 */

// Path ke public/index.php relatif terhadap file ini
$publicIndex = __DIR__ . '/public/index.php';

// Pastikan file target ada
if (!file_exists($publicIndex)) {
    http_response_code(500);
    echo 'Error: File public/index.php tidak ditemukan.';
    exit;
}

// Forward eksekusi ke public/index.php
require $publicIndex;
