<?php
require_once 'src/common.php';

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

