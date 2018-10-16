<?php
declare(strict_types=1);
require_once 'src/category_queries.php';

$cat_id = intval($_GET['category'] ?? -1);

$categories = get_all_categories($connection);

$current_category = array_reduce($categories,
        function ($carry, $category) use ($cat_id) {
            if ($category['id'] === $cat_id) {
                $carry = $category;
            }
            return $carry;
        }, null) ?? null;

require_once 'src/utils/include.php';
$navigation = include_template('templates/common/navigation.php', [
    'categories' => $categories,
    'current' => $current_category
]);