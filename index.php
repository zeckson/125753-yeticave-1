<?php
require_once 'src/include/common.php';

require_once 'src/lot_queries.php';
$lots = get_all_open_lots($connection);

$config = [
    'title' => 'Заглавная',
    'promo' => true,
    'content' => include_template('templates/page/main.php', [
        'categories' => $categories,
        'lots' => $lots
    ]),
    'navigation' => $navigation
];

render_page($config);