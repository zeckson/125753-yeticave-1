<?php
require_once 'src/include/common.php';

$lot_id = intval($_GET['id'] ?? null);

if ($lot_id <= 0) {
    http_response_code(NOT_FOUND_HTTP_STATUS_CODE);
    die();
}

require_once 'src/lot_queries.php';
$lot = get_lot_by_id($connection, $lot_id);

require_once 'src/utils/lot.php';
if (!$lot) {
    http_response_code(NOT_FOUND_HTTP_STATUS_CODE);
    die();
}

render_lot_page($connection, $navigation, $lot);
