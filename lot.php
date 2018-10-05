<?php
date_default_timezone_set('Europe/Moscow');

$current_user = rand(0, 1) ? [
    'id' => 3,
    'name' => 'Женёк Пыхарь',
    'avatar' => 'img/user.jpg'
] : null;


require_once 'src/utils.php';
$connection = setup_connection();

require_once 'src/category_queries.php';
$categories = get_all_categories($connection);

require_once 'src/lot_queries.php';
$lot = get_lot_by_id($connection, $_GET['id'] ?? null);

if ($lot !== null) {
    $navigation = include_template('templates/navigation', [
        'categories' => $categories
    ]);
    $config = [
        'title' => 'Лот "'.$lot['name'].'""',
        'current_user' => $current_user,
        'content' => include_template('templates/lot', [
            'navigation' => $navigation,
            'lot' => $lot
        ]),
        'navigation' => $navigation
    ];
    print include_template('templates/layout', $config);
} else {
    http_response_code(404);
}

