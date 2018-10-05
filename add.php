<?php
date_default_timezone_set('Europe/Moscow');

$current_user = rand(0, 1) ? [
    'name' => 'Женёк Пыхарь',
    'avatar' => 'img/user.jpg'
] : null;


require_once 'src/utils.php';
$connection = setup_connection();

require_once 'src/category_queries.php';
$categories = get_all_categories($connection);

$navigation = include_template('templates/navigation', [
    'categories' => $categories
]);
$config = [
    'title' => 'Добавить лот',
    'current_user' => $current_user,
    'content' => include_template('templates/add_lot', [
        'navigation' => $navigation,
        'categories' => $categories,
        'errors' => []
    ]),
    'navigation' => $navigation
];
print include_template('templates/layout', $config);

