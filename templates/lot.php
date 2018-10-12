<?php
//       lot.id,
//       lot.name,
//       lot.description
//       start_price,
//       IFNULL(MAX(bid.amount), start_price) AS price,
//       image_url                            AS image,
//       category.name                        AS category,
//       count(bid.id)                        AS bids_count
require_once 'src/lot_format.php';
$time_left = format_period(time_left());
$minimal_bid = format_price($lot['price'] + $lot['bid_step']);
?>
<section class="lot-item container">
    <h2><?= $lot['name'] ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot['image'] ?>" width="730" height="548"
                     alt="<?= htmlspecialchars($lot['name'], ENT_QUOTES) ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category'] ?></span></p>
            <p class="lot-item__description"><?= htmlspecialchars($lot['description']) ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer"><?= $time_left ?></div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= format_price($lot['price']) ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= $minimal_bid ?></span>
                    </div>
                </div>
                <?php if (is_logged_in()): ?>
                    <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                        <p class="lot-item__form-item">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="number" name="cost" min="<?= $lot['price'] + $lot['bid_step'] ?>"
                                   placeholder="<?= $minimal_bid ?>">
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                <?php endif ?>
            </div>
            <?php if (isset($bids)): ?>
                <div class="history">
                    <h3>История ставок (<span><?= sizeof($bids) ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($bids as $bid): ?>
                            <tr class="history__item">
                                <td class="history__name"><?= htmlspecialchars($bid['name']) ?></td>
                                <td class="history__price"><?= format_price($bid['amount']) ?></td>
                                <td class="history__time"><?= format_relative_time($bid['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
  