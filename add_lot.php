<?php
$authorized_only = true;
require_once 'src/include/common.php';

require_once 'src/user_queries.php';

$lot = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'src/utils/string.php';
    $lot = $_POST;

    $max_size = (int)ini_get('post_max_size') * 1024 * 1024;
    if (isset($_SERVER["CONTENT_LENGTH"]) && $_SERVER["CONTENT_LENGTH"] > $max_size) {
        $errors['image'] = "Размер загружаемой картинки превысил $max_size";
    } else {
        $required = ['name', 'description', 'category', 'start_price', 'bid_step', 'closed_at', 'image'];
        $fixed_lot = array_slice($lot, 0);
        foreach ($required as $key) {
            $value = trim($lot[$key] ?? '');
            $fixed_lot[$key] = $value;
            if (str_is_empty($value)) {
                $errors[$key] = 'Это поле надо заполнить';
                continue;
            }
            switch ($key) {
                case 'start_price':
                case 'bid_step':
                    $value = intval($value);
                    if ($value <= 0) {
                        $errors[$key] = 'Это поле должно быть больше ноля';
                    } else {
                        $fixed_lot[$key] = $value;
                    }
                    break;
                case 'category':
                    $value = intval($value);
                    $found_items = array_filter($categories, function ($category) use ($value) {
                        return $category['id'] === $value;
                    });
                    if (sizeof($found_items) <= 0) {
                        $errors[$key] = "Неизвестная категория: $value";
                    } else {
                        $fixed_lot[$key] = $value;
                    }
                    break;
                case 'closed_at':
                    $close_time = strtotime($value);
                    $tomorrow = strtotime('tomorrow');
                    if ($close_time < $tomorrow) {
                        $errors[$key] = 'Дата закрытия должна быть не раньше чем завтра';
                    } else {
                        $fixed_lot[$key] = mysqli_time_format($close_time);
                    }
                    break;
                case 'image':
                    // Check if file was uploaded once
                    if (!file_exists($value)) {
                        $errors[$key] = 'Неизвестный файл';
                    }
                    break;
            }
        }

        // Check uploaded file if wasn't set yet
        if (!isset($lot['image'])) {
            unset($errors['image']);
            try {
                $path = get_required_file_name('image');
                $lot['image'] = $path;
                $fixed_lot['image'] = $path;
            } catch (RuntimeException $e) {
                $errors['image'] = $e->getMessage();
            }
        }

        if (sizeof($errors) <= 0) {
            require_once 'src/lot_queries.php';
            $id = insert_new_lot($connection, $fixed_lot, get_session_current_user());
            require_once 'src/utils/links.php';
            $link = get_lot_page_link_by_id($id);
            header("Location: $link"); //
        }
    }
}
$config = [
    'title' => 'Добавить лот',
    'content' => include_template('templates/page/add_lot.php', [
        'categories' => $categories,
        'lot' => $lot,
        'errors' => $errors
    ]),
    'navigation' => $navigation
];

render_page($config);

