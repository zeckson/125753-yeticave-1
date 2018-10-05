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

function get_uploaded_file_name($fieldName) {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES[$fieldName]['error']) ||
        is_array($_FILES[$fieldName]['error'])
    ) {
        throw new RuntimeException('Файл не передан.');
    }

    // Check $_FILES[$fieldName]['error'] value.
    switch ($_FILES[$fieldName]['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('Файл не выбран.');
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

    if (!file_exists($upload_dir)) {
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