<?php
require_once 'src/include/common.php';

require_once 'src/lot_queries.php';
$lots = get_all_open_lots($connection, $cat_id);

$title = 'Все лоты';
if ($current_category) {
    $title .= " в категории «{$current_category['name']}»";
}

$config = [
    'title' => $title,
    'content' => include_template('templates/page/list.php', [
        'category' => $current_category,
        'lots' => $lots
    ]),
    'navigation' => $navigation
];

render_page($config);
