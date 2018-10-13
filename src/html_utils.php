<?php
function mark(&$var, $value = 'form__item--invalid')
{
    return mark_if_true(isset($var), $value);
}

function mark_if_true($condition, $value = 'form__item--invalid')
{
    return $condition ? $value : '';
}

/**
 * @param $value
 * @return string
 */
function write_value(&$value)
{
    return isset($value) ? htmlspecialchars($value, ENT_QUOTES) : '';
}

/**
 * @param $fieldName
 * @return null|string
 */
function get_uploaded_file_name($fieldName)
{
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES[$fieldName]['error']) ||
        is_array($_FILES[$fieldName]['error'])
    ) {
        return null;
    }

    // Check $_FILES[$fieldName]['error'] value.
    switch ($_FILES[$fieldName]['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            return null;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Файл слишком большой.');
        default:
            throw new RuntimeException('Неизвестная ошибка.');
    }

    // You should also check filesize here.
    if ($_FILES[$fieldName]['size'] > 1000000) {
        throw new RuntimeException('Превышен размер файла.');
    }

    // DO NOT TRUST $_FILES[$fieldName]['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
            $finfo->file($_FILES[$fieldName]['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
        throw new RuntimeException('Неверный формат файла.');
    }

    $upload_dir = './uploads';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, false);
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES[$fieldName]['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $image_url = sprintf('' . $upload_dir . '/%s.%s',
        sha1_file($_FILES[$fieldName]['tmp_name']),
        $ext
    );
    if (!move_uploaded_file(
        $_FILES[$fieldName]['tmp_name'],
        $image_url
    )) {
        throw new RuntimeException('Невозможно скпоировать файл.');
    }

    return $image_url;
}

/**
 * @param $fieldName
 * @return string
 */
function get_required_file_name($fieldName)
{
    $fileName = get_uploaded_file_name($fieldName);
    if ($fileName == null) {
        throw new RuntimeException('Файл не передан.');
    }
    return $fileName;
}