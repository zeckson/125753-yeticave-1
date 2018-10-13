<?php
require_once 'db.php';
require_once 'form_utils.php';

function include_template($src, array $data = null)
{

    $src = str_ends_with($src, '.php') ? $src : $src . '.php';
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
