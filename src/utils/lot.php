<?php
/**
 * @param $connection
 * @param $navigation
 * @param $lot_id
 * @param array $new_bid
 */
function render_lot_page($connection, $navigation, $lot, $new_bid = [
    'errors' => [],
    'bid' => []
])
{
    require_once 'src/bid_queries.php';
    $bids = get_all_bids_for_lot($connection, $lot['id']);


    $config = [
        'title' => 'Лот "' . $lot['name'] . '""',
        'content' => include_template('templates/page/lot.php', [
            'lot' => $lot,
            'bids' => $bids,
            'new_bid' => $new_bid
        ]),
        'navigation' => $navigation
    ];

    render_page($config);
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

function time_left()
{
    $now = time(); // PHP return timestamp in seconds (WOOOOT????)
    $tomorrow = strtotime('tomorrow');

    return $tomorrow - $now;
}

function format_period($time_left)
{
    $one_minute = 60; // seconds

    $minutes = ceil($time_left / $one_minute);
    $hours = floor($minutes / 60);
    $minutes %= 60;

    return ($hours < 10 ? '0'.$hours : $hours) . ':' . ($minutes < 10 ? '0'.$minutes : $minutes);
}

function format_relative_time($time)
{
    // TODO:
    // 5 минут назад
    // час назад
    // 19.03.17 в 08:21
    $time = strtotime($time);
    return date('d.m.y в H:i', $time);
}