<?php
/**
 * @param $var
 * @param string $value
 * @return string
 */
function mark(&$var, string $value = 'form__item--invalid'): string
{
    return mark_if_true(isset($var), $value);
}

/**
 * @param bool $condition
 * @param string $value
 * @return string
 */
function mark_if_true(bool $condition, string $value = 'form__item--invalid'): string
{
    return $condition ? $value : '';
}

/**
 * Writes value if set with sanitizing, or empty string otherwise
 * @param $value
 * @return string
 */
function html_saintize(&$value): string
{
    return isset($value) ? htmlspecialchars($value, ENT_QUOTES) : '';
}

const UPLOAD_DIR = './uploads';

/**
 * Returns uploaded filePath by given $field_name, null otherwise
 * @param string $field_name
 * @throws RuntimeException
 * @return null|string
 */
function get_uploaded_file_name(string $field_name): ?string
{
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES[$field_name]['error']) ||
        is_array($_FILES[$field_name]['error'])
    ) {
        return null;
    }

    // Check $_FILES[$field_name]['error'] value.
    switch ($_FILES[$field_name]['error']) {
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
    if ($_FILES[$field_name]['size'] > 1000000) {
        throw new RuntimeException('Превышен размер файла.');
    }

    // DO NOT TRUST $_FILES[$field_name]['mime'] VALUE !!
    // Check MIME Type by yourself.
    $file_info = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
            $file_info->file($_FILES[$field_name]['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
        throw new RuntimeException('Неверный формат файла.');
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, false);
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES[$field_name]['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $image_url = sprintf('' . UPLOAD_DIR . '/%s.%s',
        sha1_file($_FILES[$field_name]['tmp_name']),
        $ext
    );
    if (!move_uploaded_file(
        $_FILES[$field_name]['tmp_name'],
        $image_url
    )) {
        throw new RuntimeException('Невозможно скпоировать файл.');
    }

    return $image_url;
}

/**
 * @param string $fieldName
 * @throws RuntimeException
 * @return string
 */
function get_required_file_name(string $fieldName): string
{
    $fileName = get_uploaded_file_name($fieldName);
    if (!$fileName) {
        throw new RuntimeException('Файл не передан.');
    }
    return $fileName;
}