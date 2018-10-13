<?php
require_once 'src/common.php';

require_once 'src/lot_queries.php';
$lots = get_all_open_lots($connection, $cat_id);

$config = [
    'title' => 'Заглавная',
    'content' => include_template('templates/lot_list.php', [
        'category' => $current_category,
        'lots' => $lots
    ]),
    'navigation' => $navigation
];

$html = include_template('templates/layout.php', $config);

print $html;
