<?php
const CURRENT_USER = 'current_user';
session_start();

date_default_timezone_set('Europe/Moscow');

$current_user = rand(0, 1) ? [
    'name' => 'Женёк Пыхарь',
    'avatar' => 'img/user.jpg'
] : null;

if (!isset($_SESSION[CURRENT_USER])) {
    $_SESSION[CURRENT_USER] = null;
} else if (!isset($_SESSION[CURRENT_USER]['avatar_url'])) {
    $_SESSION[CURRENT_USER]['avatar_url'] = './img/user.jpg';
}

require_once 'db.php';
require_once 'navigation.php';