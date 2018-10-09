<?php
require_once 'src/common.php';
$current_user = null;

require_once 'src/user_queries.php';
$user = [];
$errors = [];

$config = [
    'title' => 'Вход',
    'current_user' => null,
    'content' => include_template('templates/login', [
        'navigation' => $navigation,
        'user' => $user,
        'errors' => $errors
    ]),
    'navigation' => $navigation
];
print include_template('templates/layout', $config);

