<?php
$authorized_only = true;
include_once 'src/include/common.php';

$title = "Мои ставки";

require_once 'src/bid_queries.php';
$my_bids = get_my_bids($connection, get_session_current_user());

$config = [
    'title' => $title,
    'content' => include_template('templates/page/my_bids.php', [
        'bids' => $my_bids,
    ]),
    'navigation' => $navigation
];

render_page($config);