<?php
require_once 'src/common.php';
$current_user = null;

require_once 'src/user_queries.php';
$user = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST;

    $required = ['email', 'password'];
    foreach ($required as $key) {
        $value = $user[$key];
        if (empty($value)) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (!get_user_by_email($connection, $user['email'])) {
        $errors['email'] = 'Пользователь с таким email не найден';
    }

    if (empty($errors)) {
        $logged_in_user = login($connection, $user['email'], $user['password']);
        if (!$logged_in_user) {
            $errors['password'] = 'Неверный пароль';
        } else {
            header('Location: /index.php');
            die();
        }
    }
}
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

