<?php
require_once 'db.php';
require_once 'category_queries.php';
$categories = get_all_categories($connection);

$navigation = include_template('templates/navigation', [
    'categories' => $categories
]);