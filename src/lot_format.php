<?php
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