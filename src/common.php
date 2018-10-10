<?php
const CURRENT_USER = 'current_user';
session_start();

date_default_timezone_set('Europe/Moscow');

if (!isset($_SESSION[CURRENT_USER])) {
    // if anonymous and page is not allowed for unauthenticated
    if (isset($authorized_only)) {
        http_response_code(403);
        die();
    } else {
        $_SESSION[CURRENT_USER] = null;
    }
} else if (!isset($_SESSION[CURRENT_USER]['avatar_url'])) {
    $_SESSION[CURRENT_USER]['avatar_url'] = './img/user.jpg';
}

require_once 'db.php';
require_once 'navigation.php';