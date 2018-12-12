<?php
declare(strict_types=1);
require_once 'src/category_queries.php';

function get_current_category(array $categories): ?array
{
    $category_name = $_GET['category'] ?? -1;
    $category_id = intval($category_name);

    return array_reduce($categories,
            function ($carry, $category) use ($category_id, $category_name) {
                if ($category['id'] === $category_id) {
                    $carry = $category;
                }
                if ($category['alias'] === $category_name) {
                    $carry = $category;
                }
                return $carry;
            }, null) ?? null;
}

$categories = get_all_categories($connection);

$current_category = get_current_category($categories);

require_once 'src/utils/include.php';
$navigation = include_template('templates/common/navigation.php', [
    'categories' => $categories,
    'current' => $current_category
]);