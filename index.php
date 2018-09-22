<?php
$current_user = rand(0, 1) ? [
    'name' => 'Женёк Пыхарь',
    'avatar' => 'img/user.jpg'
] : null;

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

require_once 'src/utils.php';

$config = [
    'title' => 'Заглавная',
    'current_user' => $current_user,
    'content' => include_template('templates/main', [
        'categories' => $categories
    ]),
    'navigation' => include_template('templates/navigation', [
        'categories' => $categories
    ])
];
$html = include_template('templates/layout', $config);

print $html;