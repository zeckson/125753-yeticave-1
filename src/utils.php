<?php
function include_template($src, array $data = null)
{
    $src = $src . '.php';
    $result = '';

    if (!file_exists($src)) {
        trigger_error("Template was not found: {$src}", E_USER_ERROR);
        return $result;
    }

    ob_start();
    if ($data) {
        extract($data);
    }
    require($src);

    $result = ob_get_clean();

    return $result;
}

function fetch_all($connection, $query, $data = [])
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

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        $error = mysqli_error($connection);
        trigger_error("Failed SQL-query: \"{$query}\" with error: $error", E_USER_ERROR);
        die;
    }

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
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