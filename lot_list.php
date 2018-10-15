<?php
const MAX_ITEMS_ON_PAGE = 9;
require_once 'src/include/common.php';

require_once 'src/lot_queries.php';
$all_lots = get_all_open_lots($connection, $cat_id);

$title = 'Все лоты';
if ($current_category) {
    $title .= " в категории «{$current_category['name']}»";
}

$cur_page = intval($_GET['page'] ?? 1);

$items_count = sizeof($all_lots);

$pages_count = ceil($items_count / MAX_ITEMS_ON_PAGE);
$offset = ($cur_page - 1) * MAX_ITEMS_ON_PAGE;

$pages = range(1, $pages_count);

// запрос на показ девяти самых популярных гифок
$lots = array_slice($all_lots, $offset, MAX_ITEMS_ON_PAGE);

$config = [
    'title' => $title,
    'content' => include_template('templates/page/list.php', [
        'category' => $current_category,
        'lots' => $lots,
        'page' => [
            'current' => $cur_page,
            'total' => $pages_count
        ]
    ]),
    'navigation' => $navigation
];

render_page($config);
