<?php
require_once 'src/common.php';

$cat_id = intval($_GET['category'] ?? null);

$category = null;
if ($cat_id > 0) {
    // TODO: get rid of extra request
    $category = get_category_by_id($connection, $cat_id);
}

require_once 'src/lot_queries.php';
$lots = get_all_open_lots($connection, $cat_id);

$config = [
    'title' => 'Заглавная',
    'content' => include_template('templates/lot_list', [
        'category' => $category,
        'lots' => $lots
    ]),
    'navigation' => $navigation];

$html = include_template('templates/layout', $config);

print $html;
