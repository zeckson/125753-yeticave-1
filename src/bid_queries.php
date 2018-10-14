<?php
include_once 'src/utils/db.php';

/**
 * @param string $where
 * @return string
 */
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


/**
 * @param mysqli $connection
 * @param int $lot_id
 * @return array|null
 */
function get_all_bids_for_lot(mysqli $connection, int $lot_id): ?array
{
    $query = create_bid_query("lot_id = ?");

    $result = fetch_all($connection, $query, [$lot_id]);
    return $result;
}

/**
 * @param mysqli $connection
 * @param int $lot_id
 * @param int $owner_id
 * @return array|null
 */
function get_all_bids_for_lot_by_user(mysqli $connection, int $lot_id, int $owner_id): ?array
{
    $query = create_bid_query("lot_id = ? AND owner_id = ?");

    $result = fetch_all($connection, $query, [$lot_id, $owner_id]);
    return $result;
}

/**
 * @param mysqli $connection
 * @param int $amount
 * @param int $lot_id
 * @param array $current_user
 * @return int|null
 */
function insert_new_bid(mysqli $connection, int $amount, int $lot_id, array $current_user): ?int
{
    $query = "INSERT INTO bids (amount, owner_id, lot_id) VALUE (?, ?, ?);";

    $result = insert_into($connection, $query, [$amount, $current_user['id'], $lot_id]);
    return $result;
}

function get_all_my_bids(mysqli $connection, array $me): array
{
    $query = "SELECT () LEFT JOIN ";
    return null;
}
