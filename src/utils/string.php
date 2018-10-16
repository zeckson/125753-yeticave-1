<?php
declare(strict_types=1);
/**
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function str_starts_with(string $haystack, string $needle): bool
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

/**
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function str_ends_with(string $haystack, string $needle): bool
{
    $length = strlen($needle);
    if (!$length) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}
