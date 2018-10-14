<?php

const SESSION_CURRENT_USER = 'current_user';
session_start();

if (!isset($_SESSION[SESSION_CURRENT_USER])) {
    // if anonymous and page is not allowed for unauthenticated
    if (isset($authorized_only)) {
        http_response_code(403);
        die();
    } else {
        $_SESSION[SESSION_CURRENT_USER] = null;
    }
} else if (!isset($_SESSION[SESSION_CURRENT_USER]['avatar_url'])) {
    $_SESSION[SESSION_CURRENT_USER]['avatar_url'] = './img/user.jpg';
}

function set_session_current_user($user): void
{
    $_SESSION[SESSION_CURRENT_USER] = $user;
}

function get_session_current_user(): ?array
{
    return $_SESSION[SESSION_CURRENT_USER] ?? null;
}

function is_logged_in(): bool
{
    return isset($_SESSION[SESSION_CURRENT_USER]);
}