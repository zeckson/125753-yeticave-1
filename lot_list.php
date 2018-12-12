<?php

require_once 'src/include/common.php';

require_once 'src/lot_queries.php';
$all_lots = get_all_open_lots($connection, $current_category['id'] ?? -1);

$title = 'Все лоты';
if ($current_category) {
    $title .= " в категории «{$current_category['name']}»";
}

require_once 'src/utils/lot.php';
$page = get_lots_page($all_lots, intval($_GET['page'] ?? 1));

$config = [
    'title' => $title,
    'content' => include_template('templates/page/list.php', [
        'category' => $current_category,
        'page' => $page
    ]),
    'navigation' => $navigation
];

render_page($config);
