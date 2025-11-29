<?php
// Root index.php to forward requests to public/index.php

// Build absolute path to public/index.php
$publicIndex = __DIR__ . '/public/index.php';

if (!file_exists($publicIndex)) {
    http_response_code(500);
    echo "Application entrypoint not found: public/index.php";
    exit;
}

// Include the real front controller
require $publicIndex;
