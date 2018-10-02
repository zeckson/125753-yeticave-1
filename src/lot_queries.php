<?php
include_once 'utils.php';

function prepare_query($where) {
    return "SELECT lot.id,
       lot.name,
       start_price,
       description,
       bid_step,
       lot.created_at,
       lot.closed_at,
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

function get_all_open_lots($connection) {
    $now = date("Y-m-d H:i:s");
    $lots_query = prepare_query("TIMESTAMP('$now') < lot.closed_at");

    $result = fetch_all($connection, $lots_query);
    return $result;
}

function get_lot_by_id($connection, $id) {
    if (!isset($id)) {
        return null;
    }
    if (is_string($id)) {
        $id = intval($id);
        if ($id === 0) { // How to detect case when we have '0' form 'xyz', since intval returns 0 in both cases
            return null;
        }
    }

    $rows = fetch_all($connection, prepare_query('lot.id = ?'), [$id]);
    return $rows[0] ?? null;
}