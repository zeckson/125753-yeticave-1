<?php
include_once 'utils.php';

function get_all_categories($connection) {
    return fetch_all($connection, 'SELECT id, name FROM categories ORDER BY id ASC');
}
