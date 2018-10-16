<?php
declare(strict_types=1);
// Set default timezone to Europe/Moscow
date_default_timezone_set('Europe/Moscow');
// Set default upload max size to 5MB in php.ini
// upload_max_filesize(5 * 1024 * 1024);

require_once 'security.php';

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

require_once 'navigation.php';

/**
 * @param string $navigation
 */
function show_not_found_page(
    string $navigation
): void {
    http_response_code(NOT_FOUND_HTTP_STATUS_CODE);

    $config = [
        'title' => 'Страница не найдена',
        'content' => include_template('templates/page/404.php'),
        'navigation' => $navigation
    ];

    render_page($config);
    die();
}
