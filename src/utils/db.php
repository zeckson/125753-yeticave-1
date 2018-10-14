<?php
/**
 * @param mysqli $connection
 * @param string $query
 * @param array $data
 * @return mysqli_stmt
 */
function prepare(mysqli $connection, string $query, array $data): mysqli_stmt
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
 * @param mysqli $connection
 * @param string $query
 * @param array $data
 * @return array|null
 */
function fetch_all(mysqli $connection, string $query, array $data = []): ?array
{
    $executed = prepare($connection, $query, $data);
    $result = mysqli_fetch_all(mysqli_stmt_get_result($executed), MYSQLI_ASSOC);
    return $result;
}

/**
 * @param mysqli $connection
 * @param string $query
 * @param array $data
 * @return int|null
 */
function insert_into(mysqli $connection, string $query, array $data = []): ?int
{
    $executed = prepare($connection, $query, $data);
    $result = mysqli_stmt_insert_id($executed);
    return $result;
}

/**
 * @param array $fields
 * @return string
 */
function insert_statement(array $fields): string
{
    return '(' . implode(',', $fields) . ') 
    VALUE (' . implode(',', array_fill(0, sizeof($fields), '?')) . ')';
}

/**
 * Formats time to mysql time format default
 * @param int|null $timestamp
 * @return string
 */
function mysqli_time_format(?int $timestamp = null): string
{
    return date("Y-m-d H:i:s", $timestamp ?? time());
}
