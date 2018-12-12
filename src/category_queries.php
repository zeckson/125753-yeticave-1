<?php
declare(strict_types=1);
include_once 'src/utils/db.php';

/**
 * @param mysqli $connection
 * @return array
 */
function get_all_categories(mysqli $connection): array
{
    return fetch_all($connection, 'SELECT id, name, alias FROM categories ORDER BY id ASC');
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

