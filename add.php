<?php
date_default_timezone_set('Europe/Moscow');

$current_user = [
    'id' => 3,
    'name' => 'Женёк Пыхарь',
    'avatar' => 'img/user.jpg'
];

require_once 'src/utils.php';
$connection = setup_connection();

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
        if (empty($lot[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        } elseif ($key === 'start_price' || $key === 'bid_step' || $key === 'category') {
            $value = intval($lot[$key]);
            $lot[$key] = $value;
            if ($value === 0) {
                $errors[$key] = 'Это поле должно быть больше 0';
            }
        }
    }

    try {
        $lot['image'] = get_uploaded_file_name('image');
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

