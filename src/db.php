<?php
/**
 * @param $connection
 * @param $query
 * @param $data
 * @return bool|mysqli_stmt
 */
function prepare($connection, $query, $data)
{
    $stmt = mysqli_prepare($connection, $query);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            } else if (is_string($value)) {
                $type = 's';
            } else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        mysqli_stmt_bind_param(...$values);
    }

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        $error = mysqli_error($connection);
        trigger_error("Failed SQL-query: \"{$query}\" with error: $error", E_USER_ERROR);
        die;
    }
    return $stmt;
}

/**
 * @param $connection
 * @param $query
 * @param array $data
 * @return array|null
 */
function fetch_all($connection, $query, $data = [])
{
    $executed = prepare($connection, $query, $data);
    $result = mysqli_fetch_all(mysqli_stmt_get_result($executed), MYSQLI_ASSOC);
    return $result;
}

/**
 * @param $connection
 * @param $query
 * @param array $data
 * @return mixed
 */
function insert_into($connection, $query, $data = [])
{
    $executed = prepare($connection, $query, $data);
    $result = mysqli_stmt_insert_id($executed);
    return $result;
}


/**
 * @return mysqli
 */
function setup_connection(): mysqli
{
    // To access to MySQL v8 and older you have to set option in `my.cnf`:
    // default-authentication-plugin=mysql_native_password
    // Long story is here: https://mysqlserverteam.com/upgrading-to-mysql-8-0-default-authentication-plugin-considerations/
    $connection = mysqli_connect('localhost', 'root', '', 'yeticave');

    if (!$connection) {
        $error = mysqli_connect_error();
        trigger_error("Failed connect to database: '{$error}'", E_USER_ERROR);
    }

    // setup charset
    mysqli_set_charset($connection, 'utf8');

    return $connection;
}

$connection = setup_connection();