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

$sql = 'SELECT name FROM categories ORDER BY id ASC';
$result = mysqli_query($connection, $sql);

$categories = [];
if (!$result) {
    $error = mysqli_error($connection);
    trigger_error("Failed SQL-query: \"{$error}\"", E_USER_ERROR);
} else {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    error_log(print_r($rows, TRUE));
    foreach ($rows as $row) {
        array_push($categories, $row['name']);
    }
}

$lots = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 10999,
        'image' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'image' => 'img/lot-2.jpg'],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'image' => 'img/lot-3.jpg'],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'image' => 'img/lot-4.jpg'],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 7500,
        'image' => 'img/lot-5.jpg'],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 5400,
        'image' => 'img/lot-6.jpg']
];

require_once 'src/utils.php';

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