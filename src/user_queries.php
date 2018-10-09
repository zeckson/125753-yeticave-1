<?php
include_once 'utils.php';

function get_random_user($connection)
{
    return fetch_all($connection, "SELECT id, name FROM users LIMIT 1");
}

function get_user_by_email($connection, $email)
{
    return fetch_all($connection, "SELECT id, name FROM users WHERE email=?", [$email]);
}

function create_new_user($connection, $user)
{
    $password = password_hash($user['password'], PASSWORD_BCRYPT);

    $fields = ['name', 'email', 'password', 'info'];
    if ($user['avatar_url']) {
        $fields[] = 'avatar_url';
    }

    $query = insert_statement($fields);
    return insert_into($connection, "INSERT INTO users $query;",
        [$user['name'], $user['email'], $password, $user['info'], $user['avatar_url']]
    );
}
