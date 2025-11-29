<?php
$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if ($requestUri !== "/" && substr($requestUri, -1) === "/") {
    $requestUri = rtrim($requestUri, "/");
}

$publicDir = __DIR__ . "/public";
$targetFile = "$publicDir/index.php";

switch ($requestUri) {
    case "/":
    case "":
        $targetFile = "$publicDir/index.php";
        break;
    case "/about.php":
    case "/about":
        $targetFile = "$publicDir/about.php";
        break;
    case "/contact.php":
    case "/contact":
        $targetFile = "$publicDir/contact.php";
        break;
    default:
        $possible = $publicDir . $requestUri;
        if (is_file($possible)) {
            $targetFile = $possible;
        } else {
            http_response_code(404);
            echo "404 Not Found";
            exit();
        }
}

if (!file_exists($targetFile)) {
    http_response_code(500);
    echo "File target tidak ditemukan: " . htmlspecialchars($targetFile);
    exit();
}

require $targetFile;
