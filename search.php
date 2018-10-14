<?php
const MAX_ITEMS_ON_PAGE = 9;
include_once 'src/include/common.php';

$query = trim($_GET['query'] ?? '');

$title = "Результаты поиска по запросу «{$query}»";
if ($current_category) {
    $title .= " в категории «{$current_category['name']}»";
}

require_once 'src/lot_queries.php';
$all_lots = get_all_open_lots_by_query($connection, $query, $cat_id);

$cur_page = intval($_GET['page'] ?? 1);

$items_count = sizeof($all_lots);

$pages_count = ceil($items_count / MAX_ITEMS_ON_PAGE);
$offset = ($cur_page - 1) * MAX_ITEMS_ON_PAGE;

$pages = range(1, $pages_count);

$lots = array_slice($all_lots, $offset, MAX_ITEMS_ON_PAGE);

$config = [
    'title' => $title,
    'query' => $query,
    'content' => include_template('templates/page/search.php', [
        'query' => $query,
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