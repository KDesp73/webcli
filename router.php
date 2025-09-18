<?php

// Get the requested path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// --- Serve static frontend files ---
$frontendPath = __DIR__ . '/src/frontend' . $uri;
if ($uri !== '/' && file_exists($frontendPath) && !is_dir($frontendPath)) {
    return false; // let PHP’s built-in server handle the file
}

// --- API routing ---
if (str_starts_with($uri, '/api/')) {
    $apiPath = __DIR__ . '/src/backend' . $uri;
    if (file_exists($apiPath)) {
        require $apiPath;
        return true;
    }
    http_response_code(404);
    echo "API endpoint not found.";
    return true;
}

// --- Default: frontend app (SPA fallback) ---
require __DIR__ . '/src/frontend/index.html';

?>
