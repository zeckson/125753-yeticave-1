<?php
$lot_id = intval($_GET['id'] ?? null);

if ($lot_id <= 0) {
    http_response_code(404);
    die();
}

require_once 'src/common.php';

require_once 'src/lot_queries.php';
$lot = get_lot_by_id($connection, $lot_id);

if ($lot == null) {
    http_response_code(404);
    die();
}

require_once 'src/lot_utils.php';
render_lot_page($connection, $navigation, $lot);
