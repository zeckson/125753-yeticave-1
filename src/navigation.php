<?php
require_once 'db.php';
require_once 'category_queries.php';

$cat_id = intval($_GET['category'] ?? null);

$categories = get_all_categories($connection);

$navigation = include_template('templates/navigation', [
    'categories' => $categories,
    'current_id' => $cat_id
]);