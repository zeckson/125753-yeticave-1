<?php

function get_category_page_link($category): string
{
    return "lot_list.php?category={$category['id']}";
}

function get_lot_page_link_by_id($lot_id): string
{
    return "lot.php?id=$lot_id";
}

function get_index_page_link(): string
{
    return "index.php";
}

function get_login_page_link(): string
{
    return "index.php";
}

function get_signin_page_link(): string
{
    return "index.php";
}