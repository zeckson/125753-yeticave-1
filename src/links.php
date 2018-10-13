<?php

function get_category_link($category)
{
    return "lot_list.php?category={$category['id']}";
}

function get_lot_link_by_id($lot_id)
{
    return "lot.php?id=$lot_id";
}