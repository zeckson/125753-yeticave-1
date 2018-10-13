<?php
include_once 'src/utils/db.php';

function create_bid_query(string $where): string
{
    $query = "SELECT amount, b.created_at, u.name 
FROM bids b
JOIN users u ON owner_id = u.id 
WHERE $where 
GROUP BY b.id 
ORDER BY b.created_at DESC;";
    return $query;
}


function get_all_bids_for_lot(mysqli $connection, int $lot_id): ?array
{
    $query = create_bid_query("lot_id = ?");

    $result = fetch_all($connection, $query, [$lot_id]);
    return $result;
}

function get_all_bids_for_lot_by_user(mysqli $connection, int $lot_id, int $owner_id): ?array
{
    $query = create_bid_query("lot_id = ? AND owner_id = ?");

    $result = fetch_all($connection, $query, [$lot_id, $owner_id]);
    return $result;
}

function insert_new_bid($connection, $amount, $lot_id, $current_user)
{
    $query = "INSERT INTO bids (amount, owner_id, lot_id) VALUE (?, ?, ?);";

    $result = insert_into($connection, $query, [$amount, $current_user['id'], $lot_id]);
    return $result;
}
