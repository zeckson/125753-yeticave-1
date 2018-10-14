<?php
include_once 'src/utils/db.php';

function get_all_categories($connection)
{
    return fetch_all($connection, 'SELECT id, name FROM categories ORDER BY id ASC');
}

function get_category_by_id($connection, int $id)
{
    $found = fetch_all($connection, 'SELECT id, name FROM categories WHERE id = ?', [$id]);
    return $found[0] ?? null;
}

