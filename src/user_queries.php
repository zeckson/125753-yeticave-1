<?php
include_once 'src/utils/db.php';

/**
 * @param mysqli $connection
 * @param string $email
 * @return array
 */
function get_user_by_email(mysqli $connection, string $email): array
{
    return fetch_all($connection, "SELECT id FROM users WHERE email=?", [$email]);
}

/**
 * @param mysqli $connection
 * @param int $user_id
 * @return array|null
 */
function get_user_by_id(mysqli $connection, int $user_id): ?array
{
    return fetch_all($connection, "SELECT id, name, email FROM users WHERE id=?", [$user_id])[0] ?? null;
}

/**
 * @param mysqli $connection
 * @param array $user
 * @return int|null
 */
function create_new_user(mysqli $connection, array $user): ?int
{
    $password = password_hash($user['password'] . $user['email'], PASSWORD_BCRYPT);

    $fields = ['name', 'email', 'password', 'info'];
    if ($user['avatar_url']) {
        $fields[] = 'avatar_url';
    }

    $query = insert_statement($fields);
    return insert_into($connection, "INSERT INTO users $query;",
        [$user['name'], $user['email'], $password, $user['info'], $user['avatar_url']]
    );
}

/**
 * @param mysqli $connection
 * @param string $email
 * @param string $password
 * @return array
 */
function login(mysqli $connection, string $email, string $password): ?array
{
    $user = fetch_all($connection, "SELECT id, name, password, avatar_url FROM users WHERE email=?", [$email]);

    if (!$user) {
        return null;
    }

    if (!isset($user[0])) {
        return null;
    }

    $user = $user[0];

    if (!password_verify($password . $email, $user['password'])) {
        return null;
    }

    return $user;
}
