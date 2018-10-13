<?php
require_once 'src/common.php';
require_once 'src/links.php';
$index = get_index_page_link();
if (isset($_SESSION[SESSION_CURRENT_USER])) {
    header("Location: $index");
    die();
}

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
            set_session_current_user($logged_in_user);
            header("Location: $index");
            die();
        }
    }
}
$config = [
    'title' => 'Вход',
    'content' => include_template('templates/page/login.php', [
        'user' => $user,
        'errors' => $errors
    ]),
    'navigation' => $navigation
];

render_page($config);
