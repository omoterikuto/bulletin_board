<?php

ini_set('display_errors', 1);

define('DSN', 'mysql:host=mysql141.phy.lolipop.lan;dbname=LAA1104681-upload;charset=utf8');
define('DB_USERNAME', 'LAA1104681');
define('DB_PASSWORD', 'Roim0624');
define('ADMIN_PASSWORD', 'password');

define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('HOME_DIR',  SITE_URL . '/works/upload/public_html');
define('MAX_FILE_SIZE', 100 * 1024 * 1024); // 100MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '/../images');
define('THUMBNAIL_DIR', __DIR__ . '/../thumbs');

require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');

session_start();