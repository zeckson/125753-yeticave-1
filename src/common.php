<?php
declare(strict_types=1);
// Set default timezone to Europe/Moscow
date_default_timezone_set('Europe/Moscow');
// Set default upload max size to 5MB in php.ini
// upload_max_filesize(5 * 1024 * 1024);

require_once 'security.php';
require_once 'db.php';
require_once 'navigation.php';