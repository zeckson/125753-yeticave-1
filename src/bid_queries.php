<?php
declare(strict_types=1);
include_once 'src/utils/db.php';

/**
 * @param string $where
 * @return string
 */
function create_bid_query(string $where): string
{
    $query = "SELECT amount, b.created_at, u.name, owner_id 
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

/**
 * @param mysqli $connection
 * @param array $me
 * @return array
 */
function get_my_bids(mysqli $connection, array $me): array
{
    $query = "
SELECT 
  bid.amount, 
  bid.created_at, 
  lot.id AS lot_id,
  lot.image_url AS lot_image,
  lot.name AS lot_name,
  lot.winner_id AS lot_winner,
  lot.closed_at AS lot_closed_at,
  usr.info AS author_contact,
  bid.owner_id = lot.winner_id AS has_won
FROM bids bid
JOIN lots lot ON bid.lot_id = lot.id
JOIN categories category ON category.id = lot.category_id
JOIN users usr ON lot.author_id = usr.id 
WHERE bid.owner_id = ?
GROUP BY bid.id 
ORDER BY bid.created_at DESC;";
    return fetch_all($connection, $query, [$me['id']]);
}
