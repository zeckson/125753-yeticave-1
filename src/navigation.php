<?php
require_once 'db.php';
require_once 'category_queries.php';

$cat_id = intval($_GET['category'] ?? -1);

$categories = get_all_categories($connection);

$current_category = array_reduce($categories,
        function ($carry, $category) use ($cat_id) {
            if ($category['id'] === $cat_id) {
                $carry = $category;
            }
            return $carry;
        }, null) ?? null;

$navigation = include_template('templates/navigation', [
    'categories' => $categories,
    'current' => $current_category
]);