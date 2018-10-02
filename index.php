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

require_once 'src/lot_queries.php';
$lots = get_all_open_lots($connection);

$config = [
    'title' => 'Заглавная',
    'current_user' => $current_user,
    'content' => include_template('templates/main', [
        'categories' => $categories,
        'lots' => $lots
    ]),
    'navigation' => include_template('templates/navigation', [
        'categories' => $categories
    ])
];
$html = include_template('templates/layout', $config);

print $html;