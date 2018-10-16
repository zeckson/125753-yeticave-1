<?php
declare(strict_types=1);
/**
 * @param string $src
 * @param array|null $data
 * @return string
 */
function include_template(string $src, array $data = null): string
{

    $result = '';

    if (!file_exists($src)) {
        trigger_error("Template was not found: {$src}", E_USER_ERROR);
        return $result;
    }

    ob_start();
    if ($data) {
        extract($data);
    }
    require($src);

    $result = ob_get_clean();

    return $result;
}

/**
 * @param array $page
 */
function render_page(array $page): void
{
    print include_template('templates/common/layout.php', $page);
}
