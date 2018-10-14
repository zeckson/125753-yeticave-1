<?php
require_once 'src/bid_queries.php';

function render_lot_page(
    mysqli $connection,
    string $navigation,
    array $lot,
    array $new_bid = [
        'errors' => [],
        'bid' => []
    ]
): void {
    $bids = get_all_bids_for_lot($connection, $lot['id']);


    $config = [
        'title' => 'Лот "' . $lot['name'] . '""',
        'content' => include_template('templates/page/lot.php', [
            'lot' => $lot,
            'user_can_add_bid' => can_add_bid($connection, $lot),
            'bids' => $bids,
            'new_bid' => $new_bid
        ]),
        'navigation' => $navigation
    ];

    render_page($config);
}

function can_add_bid(mysqli $connection, array $lot): bool
{
    // Can't add bid if closed
    if (lot_is_closed($lot)) {
        return false;
    }

    // Can't add bid if not authorized
    if (!is_logged_in()) {
        return false;
    }

    // Can't add bid to her lot
    $user_id = get_session_current_user()['id'];
    if ($user_id === $lot['author_id']) {
        return false;
    }

    // Can't add bid if already added
    $bids = get_all_bids_for_lot_by_user($connection, $lot['id'], $user_id);
    if (sizeof($bids) > 0) {
        return false;
    }

    return true;
}


function format_price($price)
{
    $part_length = 3;

    $original = ceil($price);

    $result = '';
    $length = strlen($original);
    $parts = ceil($length / $part_length);

    for ($part = 0; $part < $parts; $part++) {
        $part_start = $length - $part * $part_length;
        $start = $part_start < $part_length ? 0 : $part_start - $part_length;

        $rank = substr($original, $start, min($part_length, $part_start));

        if ($part === 0) {
            $result = $rank;
        } else {
            $result = $rank . ' ' . $result;
        }
    }

    return $result . ' ₽';
}

function lot_is_closed(array $lot): bool
{
    $close_ts = strtotime($lot['closed_at']);
    return $close_ts < time();
}

function time_left(string $closed_at): int
{
    $now = time(); // PHP return timestamp in seconds =(
    $close_ts = strtotime($closed_at);

    return $close_ts - $now;
}

function format_period($time_left)
{
    $one_minute = 60; // seconds

    $minutes = ceil($time_left / $one_minute);
    $hours = floor($minutes / 60);
    $minutes %= 60;

    return ($hours < 10 ? '0' . $hours : $hours) . ':' . ($minutes < 10 ? '0' . $minutes : $minutes);
}

function pluralize(int $n, array $forms): string
{
    return $n % 10 == 1 && $n % 100 != 11 ? $forms[0] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $forms[1] : $forms[2]);
}

function format_relative_time(int $time): string
{
    $diff = time() - $time;
    if ($diff == 0) {
        return 'только что';
    } else if ($diff >0) {
        $day_diff = floor($diff / 86400);
        $days = $day_diff;
        if ($days == 0) {
            if ($diff < 60) {
                return 'менее минуты назад';
            }
            if ($diff < 120) {
                return 'минуту назад';
            }
            if ($diff < 3600) {
                $minutes = floor($diff / 60);
                $minute_form = pluralize($minutes, ['минуту', 'минуты', 'минут']);
                return "$minutes $minute_form назад";
            }
            if ($diff < 7200) {
                return 'час назад';
            }
            if ($diff < 86400) {
                $hours = floor($diff / 3600);
                $hours_form = pluralize($hours, ['час', 'часа', 'часов']);
                return "$hours $hours_form назад";
            }
        }
        if ($days == 1) {
            return 'вчера';
        }
        if ($days < 7) {
            $days_form = pluralize($days, ['день', 'дня', 'дней']);
            return "$days $days_form назад";
        }
    }
    return date('d.m.y в H:i', $time);
}