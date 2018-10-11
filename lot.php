<?php
require_once 'src/common.php';

require_once 'src/lot_queries.php';
$lot_id = intval($_GET['id'] ?? null);

if ($lot_id <= 0) {
    http_response_code(404);
    die();
}

$lot = get_lot_by_id($connection, $lot_id);

if ($lot == null) {
    http_response_code(404);
    die();
}

require_once 'src/bid_queries.php';
$bids = get_all_bids_for_lot($connection, $lot_id);

$config = [
    'title' => 'Лот "' . $lot['name'] . '""',
    'content' => include_template('templates/lot', [
        'lot' => $lot,
        'bids' => $bids
    ]),
    'navigation' => $navigation
];

print include_template('templates/layout', $config);

