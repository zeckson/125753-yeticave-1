<?php
require_once 'src/lot_format.php';
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

    return $hours . ':' . ($minutes % 60);
}

$time_left = format_period(time_left());
?>
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
        горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $category): ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= $category ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($lots as $lot): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $lot['image'] ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['name'], ENT_QUOTES) ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $lot['category'] ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= htmlspecialchars($lot['name'], ENT_QUOTES) ?></a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= format_price($lot['price']) ?></span>
                        </div>
                        <div class="lot__timer timer">
                            <?= $time_left ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>