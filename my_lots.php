<?php
$authorized_only = true;
include_once 'src/include/common.php';

$title = "Мои ставки";

require_once 'src/bid_queries.php';
$all_lots = get_all_my_bids($connection, get_session_current_user());

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