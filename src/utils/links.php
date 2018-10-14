<?php
/** Router script. Contains all routes in app. **/

/**
 * @param array $category
 * @return string
 */
function get_category_page_link(array $category): string
{
    return "lot_list.php?category={$category['id']}";
}

/**
 * @param int $lot_id
 * @return string
 */
function get_lot_page_link_by_id(int $lot_id): string
{
    return "lot.php?id=$lot_id";
}

/**
 * @return string
 */
function get_add_lot_page_link(): string
{
    return "add_lot.php";
}

/**
 * @param int $lot_id
 * @return string
 */
function get_add_bid_page_link(int $lot_id): string
{
    return "add_bid.php?lot_id=$lot_id";
}

/**
 * @return string
 */
function get_index_page_link(): string
{
    return "index.php";
}

/**
 * @return string
 */
function get_login_page_link(): string
{
    return "login.php";
}

/**
 * @return string
 */
function get_logout_page_link(): string
{
    return "logout.php";
}

/**
 * @return string
 */
function get_register_page_link(): string
{
    return "register.php";
}