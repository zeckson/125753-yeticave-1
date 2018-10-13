<?php
require_once 'src/common.php';

require_once 'src/lot_queries.php';
$lots = get_all_open_lots($connection, $cat_id);

$config = [
    'title' => 'Заглавная',
    'content' => include_template('templates/lot/list.php', [
        'category' => $current_category,
        'lots' => $lots
    ]),
    'navigation' => $navigation
];

render_page($config);
