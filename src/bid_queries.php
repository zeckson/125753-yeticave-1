<?php
include_once 'src/utils/db.php';

function get_all_bids_for_lot($connection, $lot_id)
{
    $query = "SELECT amount, b.created_at, u.name 
FROM bids b
JOIN users u ON owner_id = u.id 
WHERE lot_id = ? 
GROUP BY b.id 
ORDER BY b.created_at DESC;";

    $result = fetch_all($connection, $query, [$lot_id]);
    return $result;
}

function insert_new_bid($connection, $amount, $lot_id, $current_user)
{
    $query = "INSERT INTO bids (amount, owner_id, lot_id) VALUE (?, ?, ?);";

    $result = insert_into($connection, $query, [$amount, $current_user['id'], $lot_id]);
    return $result;
}
