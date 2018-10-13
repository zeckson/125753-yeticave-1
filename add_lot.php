<?php
$authorized_only = true;
require_once 'src/common.php';

require_once 'src/user_queries.php';

$lot = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    $max_size = (int)ini_get('post_max_size') * 1024 * 1024;
    if (isset($_SERVER["CONTENT_LENGTH"]) && $_SERVER["CONTENT_LENGTH"] > $max_size) {
        $errors['image'] = "Размер загружаемой картинки превысил $max_size";
    } else {
        $required = ['name', 'description', 'category', 'start_price', 'bid_step', 'closed_at'];
        foreach ($required as $key) {
            $value = $lot[$key];
            if (empty($value)) {
                $errors[$key] = 'Это поле надо заполнить';
                continue;
            }
            switch ($key) {
                case 'start_price':
                case 'bid_step':
                case 'category':
                    $value = intval($value);
                    if ($value <= 0) {
                        $errors[$key] = 'Это поле должно быть больше 0';
                    } else {
                        $lot[$key] = $value;
                    }
                    break;
                case 'closed_at':
                    $close_time = strtotime($value);
                    $tomorrow = strtotime('tomorrow');
                    if ($close_time < $tomorrow) {
                        $errors[$key] = 'Дата закрытия должна быть не раньше чем завтра';
                    } else {
                        $lot[$key] = date('Y-m-d H:i:s', $close_time);
                    }
                    break;
            }
        }

        try {
            $lot['image'] = get_required_file_name('image');
        } catch (RuntimeException $e) {
            $errors['image'] = $e->getMessage();
        }

        if (empty($errors)) {
            require_once 'src/lot_queries.php';
            $id = insert_new_lot($connection, $lot, get_session_current_user());
            require_once 'src/links.php';
            $link = get_lot_page_link_by_id($id);
            header("Location: $link"); //
        }
    }
}
$config = [
    'title' => 'Добавить лот',
    'content' => include_template('templates/lot/add_lot.php', [
        'categories' => $categories,
        'lot' => $lot,
        'errors' => $errors
    ]),
    'navigation' => $navigation
];

render_page($config);

