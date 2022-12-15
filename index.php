<?php

$cwd = getcwd();

// Load environment variables from .env file
require('site/libs/dotenv.php');
if (is_file(__DIR__ . '/.env')) {
    (new DotEnv(__DIR__ . '/.env'))->load();
}

$deploy_secret = getenv('DEPLOY_SECRET');

$request = $_SERVER['REQUEST_URI'];

$page = ltrim(rtrim($request,"/"), "/");
$content_file = $page ? __DIR__ . "/content/" . $page . ".md"  : null;

if (in_array($request, [ "", "/" ])) {

    require('site/views/index.php');

} else if ($content_file && is_file($content_file)) {

    require('site/views/markdown.php');

} else if (str_starts_with($request, "/assets") && is_file(__DIR__ . $request)) {

    return false;  # Serve static files by web server

} else if ($deploy_secret && $request == '/deploy/' . $deploy_secret) {

    # Request to /deploy/<DEPLOY_SECRET>, pull latest changes from GitHub
    require('site/libs/deployCuy.php');

} else {

    http_response_code(404);
    require('site/views/404.php');

}