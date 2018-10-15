<?php
include_once 'src/utils/db.php';

/**
 * @param string $where
 * @return string
 */
function prepare_lot_select_query(string $where): string
{
    return "SELECT lot.id,
       lot.name,
       start_price,
       description,
       bid_step,
       lot.created_at,
       lot.closed_at,
       lot.author_id,
       IFNULL(MAX(bid.amount), start_price) AS price,
       image_url                            AS image,
       category.name                        AS category,
       count(bid.id)                        AS bids_count
FROM lots lot
       LEFT JOIN categories category ON lot.category_id = category.id
       LEFT JOIN bids bid ON lot.id = bid.lot_id
WHERE $where
GROUP BY lot.id
ORDER BY lot.created_at DESC";
}

/**
 * @param mysqli $connection
 * @param int $cat_id
 * @return array|null
 */
function get_all_open_lots(mysqli $connection, int $cat_id = -1): ?array
{
    $now = mysqli_time_format();
    $where = "TIMESTAMP('$now') < lot.closed_at";
    if ($cat_id >= 0) {
        $where = $where . " AND lot.category_id = $cat_id";
    }
    $lots_query = prepare_lot_select_query($where);

    $result = fetch_all($connection, $lots_query);
    return $result;
}

/**
 * @param mysqli $connection
 * @param int $id
 * @return array|null
 */
function get_lot_by_id(mysqli $connection, int $id): ?array
{
    if (!isset($id)) {
        return null;
    }
    if (is_string($id)) {
        $id = intval($id);
        if ($id === 0) {
            return null;
        }
    }

    $rows = fetch_all($connection, prepare_lot_select_query('lot.id = ?'), [$id]);
    return $rows[0] ?? null;
}

/**
 * @param mysqli $connection
 * @param array $lot
 * @param array $current_user
 * @return int|null
 */
function insert_new_lot(mysqli $connection, array $lot, array $current_user): ?int
{

    return insert_into($connection, "INSERT INTO lots (name, description, category_id, start_price, image_url, bid_step, closed_at, author_id)
VALUE (?, ?, ?, ?, ?, ?, ?, ?);", [
        $lot['name'],
        $lot['description'],
        $lot['category'],
        $lot['start_price'],
        $lot['image'],
        $lot['bid_step'],
        $lot['closed_at'],
        $current_user['id']
    ]);
}