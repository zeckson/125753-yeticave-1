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

/**
 * @param $fieldName
 * @return null|string
 */
function get_uploaded_file_name($fieldName)
{
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES[$fieldName]['error']) ||
        is_array($_FILES[$fieldName]['error'])
    ) {
        return null;
    }

    // Check $_FILES[$fieldName]['error'] value.
    switch ($_FILES[$fieldName]['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            return null;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Файл слишком большой.');
        default:
            throw new RuntimeException('Неизвестная ошибка.');
    }

    // You should also check filesize here.
    if ($_FILES[$fieldName]['size'] > 1000000) {
        throw new RuntimeException('Превышен размер файла.');
    }

    // DO NOT TRUST $_FILES[$fieldName]['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
            $finfo->file($_FILES[$fieldName]['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
        throw new RuntimeException('Неверный формат файла.');
    }

    $upload_dir = './uploads';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, false);
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES[$fieldName]['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $image_url = sprintf('' . $upload_dir . '/%s.%s',
        sha1_file($_FILES[$fieldName]['tmp_name']),
        $ext
    );
    if (!move_uploaded_file(
        $_FILES[$fieldName]['tmp_name'],
        $image_url
    )) {
        throw new RuntimeException('Невозможно скпоировать файл.');
    }

    return $image_url;
}

/**
 * @param $fieldName
 * @return string
 */
function get_required_file_name($fieldName)
{
    $fileName = get_uploaded_file_name($fieldName);
    if ($fileName == null) {
        throw new RuntimeException('Файл не передан.');
    }
    return $fileName;
}