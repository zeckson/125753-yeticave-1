<?php
$authorized_only = true;
require_once 'src/common.php';

$lot_id = intval($_GET['lot_id'] ?? null);

if ($lot_id <= 0) {
    http_response_code(404);
    die();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /lot.php?id=" . $lot_id);
    die();
}

require_once 'src/lot_queries.php';
$lot = get_lot_by_id($connection, $lot_id);

if ($lot == null) {
    http_response_code(404);
    die();
}

$bid = $_POST;
$errors = [];

$amountFieldName = 'amount';
$amount = intval($bid[$amountFieldName]);

$minimal_bid = $lot['price'] + $lot['bid_step'];
if ($amount <= $minimal_bid) {
    $errors[$amountFieldName] = "Ставка не может быть меньше $minimal_bid";
}

if (empty($errors)) {
    require_once 'src/bid_queries.php';
    $id = insert_new_bid($connection, $amount, $lot_id, get_session_current_user());
    header("Location: /lot.php?id=" . $lot_id);
    die();
}

require_once 'src/lot_utils.php';
render_lot_page($connection, $navigation, $lot, [
    'bid' => $bid,
    'errors' => $errors
]);
