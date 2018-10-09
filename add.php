<?php
date_default_timezone_set('Europe/Moscow');

require_once 'src/utils.php';
$connection = setup_connection();

require_once 'src/user_queries.php';
$current_user = get_random_user($connection)[0];
$current_user['avatar'] = 'img/user.jpg';

require_once 'src/category_queries.php';
$categories = get_all_categories($connection);

$navigation = include_template('templates/navigation', [
    'categories' => $categories
]);

$lot = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    $required = ['name', 'description', 'category', 'start_price', 'bid_step', 'closed_at'];
    foreach ($required as $key) {
        $value = $lot[$key];
        if (empty($value)) {
            $errors[$key] = 'Это поле надо заполнить';
            continue;
        }
        switch ($key) {
            case 'start_price':
            case 'bid_step':
            case 'category':
                $value = intval($value);
                if ($value <= 0) {
                    $errors[$key] = 'Это поле должно быть больше 0';
                } else {
                    $lot[$key] = $value;
                }
                break;
            case 'closed_at':
                $close_time = strtotime($value);
                $tomorrow = strtotime('tomorrow');
                if ($close_time < $tomorrow) {
                    $errors[$key] = 'Дата закрытия должна быть не раньше чем завтра';
                } else {
                    $lot[$key] = date( 'Y-m-d H:i:s', $close_time );
                }
                break;
        }
    }

    try {
        $lot['image'] = get_required_file_name('image');
    } catch (RuntimeException $e) {
        $errors['image'] = $e->getMessage();
    }

    if (empty($errors)) {
        require_once 'src/lot_queries.php';
        $id = insert_new_lot($connection, $lot, $current_user);
        header("Location: /lot.php?id=" . $id); //
    }
}
$config = [
    'title' => 'Добавить лот',
    'current_user' => $current_user,
    'content' => include_template('templates/add_lot', [
        'navigation' => $navigation,
        'categories' => $categories,
        'lot' => $lot,
        'errors' => $errors
    ]),
    'navigation' => $navigation
];
print include_template('templates/layout', $config);

