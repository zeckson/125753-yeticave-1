<?php
require_once 'src/common.php';

require_once 'src/lot_queries.php';
$lots = get_all_open_lots($connection);

$config = [
    'title' => 'Заглавная',
    'promo' => true,
    'content' => include_template('templates/main', [
        'categories' => $categories,
        'lots' => $lots
    ]),
    'navigation' => $navigation];

$html = include_template('templates/layout', $config);

print $html;