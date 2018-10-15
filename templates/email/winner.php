<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= write_value($user['name']) ?></p>
<p>Ваша ставка для лота <a
            href="<?= BASE_URL . '/' . get_lot_page_link_by_id($lot['id']) ?>"><?= write_value($lot['name']) ?></a>
    победила.
</p>
<p>Перейдите по ссылке <a href="<?= BASE_URL . '/' . get_my_bids_link() ?>">мои ставки</a>,
    чтобы связаться с автором объявления</p>

<small>Интернет Аукцион "YetiCave"</small>
</body>
</html>