<?php
include_once 'src/include/common.php';

$query = trim($_GET['query'] ?? '');

$title = "Результаты поиска по запросу «{$query}»";
if ($current_category) {
    $title .= " в категории «{$current_category['name']}»";
}

require_once 'src/lot_queries.php';
$all_lots = get_all_open_lots_by_query($connection, $query, $category_id);

require_once 'src/utils/lot.php';
$page = get_lots_page($all_lots, intval($_GET['page'] ?? 1));

$config = [
    'title' => $title,
    'query' => $query,
    'content' => include_template('templates/page/list.php', [
        'query' => $query,
        'category' => $current_category,
        'page' => $page
    ]),
    'navigation' => $navigation
];

render_page($config);