<?php
date_default_timezone_set('Europe/Moscow');

$current_user = rand(0, 1) ? [
    'name' => 'Женёк Пыхарь',
    'avatar' => 'img/user.jpg'
] : null;

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

require_once 'src/utils.php';

$categories = fetch_all($connection, 'SELECT id, name FROM categories ORDER BY id ASC');

$lot_query = 'SELECT lot.id,
       lot.name,
       start_price,
       IFNULL(MAX(bid.amount), start_price) AS price,
       image_url,
       category.name                        AS category_name,
       count(bid.id)                        AS bids_count
FROM lots lot
       LEFT JOIN categories category ON lot.category_id = category.id
       LEFT JOIN bids bid ON lot.id = bid.lot_id
WHERE lot.closed_at IS NULL
GROUP BY lot.id
ORDER BY lot.created_at DESC';

$lots = fetch_all($connection, $lot_query);

$config = [
    'title' => 'Заглавная',
    'current_user' => $current_user,
    'content' => include_template('templates/main', [
        'categories' => $categories,
        'lots' => $lots
    ]),
    'navigation' => include_template('templates/navigation', [
        'categories' => $categories
    ])
];
$html = include_template('templates/layout', $config);

print $html;