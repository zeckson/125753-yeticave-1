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

function fetch_all($connection, $query)
{
    $result = mysqli_query($connection, $query);

    if (!$result) {
        $error = mysqli_error($connection);
        trigger_error("Failed SQL-query: \"{$query}\" with error: $error", E_USER_ERROR);
        die;
    }

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}
