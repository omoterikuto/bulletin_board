<?php

ini_set('display_errors', 1);

define('DSN', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('ADMIN_PASSWORD', 'password');

define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('HOME_DIR',  SITE_URL . '/upload/public_html');
define('MAX_FILE_SIZE', 100 * 1024 * 1024); // 100MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '/../images');
define('THUMBNAIL_DIR', __DIR__ . '/../thumbs');

require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');

session_start();
