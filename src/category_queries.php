<?php
include_once 'src/utils/db.php';

/**
 * @param mysqli $connection
 * @return array|null
 */
function get_all_categories(mysqli $connection): ?array
{
    return fetch_all($connection, 'SELECT id, name FROM categories ORDER BY id ASC');
}

/**
 * @param mysqli $connection
 * @param int $id
 * @return array|null
 */
function get_category_by_id(mysqli $connection, int $id): ?array
{
    $found = fetch_all($connection, 'SELECT id, name FROM categories WHERE id = ?', [$id]);
    return $found[0] ?? null;
}

