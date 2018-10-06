<?php
include_once 'utils.php';

function get_random_user($connection)
{
    return fetch_all($connection, "SELECT id, name FROM users LIMIT 1");
}
