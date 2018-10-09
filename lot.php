<?php
require_once 'src/common.php';

require_once 'src/lot_queries.php';
$lot = get_lot_by_id($connection, $_GET['id'] ?? null);

if ($lot == null) {
    http_response_code(404);
    die();
}

$config = [
    'title' => 'Лот "' . $lot['name'] . '""',
    'content' => include_template('templates/lot', [
        'navigation' => $navigation,
        'lot' => $lot
    ]),
    'navigation' => $navigation
];

print include_template('templates/layout', $config);

