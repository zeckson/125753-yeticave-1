<?php
//       lot.id,
//       lot.name,
//       lot.description
//       start_price,
//       IFNULL(MAX(bid.amount), start_price) AS price,
//       image_url                            AS image,
//       category.name                        AS category,
//       count(bid.id)                        AS bids_count
require_once 'src/utils/lot.php';
/**
 * @var array $new_bid
 * @var bool $user_can_add_bid
 */
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
        <?php if ($user_can_add_bid): ?>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="lot-item__timer timer timer--finishing"><?= format_period(time_left($lot['closed_at'])) ?></div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= format_price($lot['price']) ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= format_price($lot['price'] + $lot['bid_step']) ?></span>
                        </div>
                    </div>
                    <?= include_template("templates/block/add_bid.php", array_merge(['lot' => $lot], $new_bid)) ?>
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
        <?php endif ?>
    </div>
</section>
  