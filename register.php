<?php
require_once 'src/common.php';
$current_user = null;

require_once 'src/user_queries.php';
$user = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST;

    $required = ['email', 'password', 'name', 'info'];
    foreach ($required as $key) {
        $value = $user[$key];
        if (empty($value)) {
            $errors[$key] = 'Это поле надо заполнить';
            continue;
        }
        switch ($key) {
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$key] = 'Некорректный email';
                }
                break;
        }
    }

    try {
        $user['avatar_url'] = get_uploaded_file_name('avatar');
    } catch (RuntimeException $e) {
        $errors['avatar_url'] = $e->getMessage();
    }

    if(get_user_by_email($connection, $user['email'])) {
        $errors['email'] = 'Пользователь с таким email уже создан';
    }

    if (empty($errors)) {
        $id = create_new_user($connection, $user);
        header('Location: /login.php'); //
    }
}
$config = [
    'title' => 'Регистрация',
    'current_user' => null,
    'content' => include_template('templates/register', [
        'navigation' => $navigation,
        'user' => $user,
        'errors' => $errors
    ]),
    'navigation' => $navigation
];
print include_template('templates/layout', $config);

