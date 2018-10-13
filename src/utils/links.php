<?php

function get_category_page_link($category): string
{
    return "lot_list.php?category={$category['id']}";
}

function get_lot_page_link_by_id($lot_id): string
{
    return "lot.php?id=$lot_id";
}

function get_add_lot_page_link(): string
{
    return "add_lot.php";
}

function get_add_bid_page_link($lot_id): string
{
    return "add_bid.php?lot_id=$lot_id";
}

function get_index_page_link(): string
{
    return "index.php";
}

function get_login_page_link(): string
{
    return "login.php";
}

function get_logout_page_link(): string
{
    return "logout.php";
}

function get_register_page_link(): string
{
    return "register.php";
}