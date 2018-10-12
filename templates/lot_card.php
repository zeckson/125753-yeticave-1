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
?>
<li class="lots__item lot">
    <div class="lot__image">
        <img src="<?= $lot['image'] ?>" width="350" height="260"
             alt="<?= htmlspecialchars($lot['name'], ENT_QUOTES) ?>">
    </div>
    <div class="lot__info">
        <span class="lot__category"><?= $lot['category'] ?></span>
        <h3 class="lot__title"><a class="text-link"
                                  href="lot.php?id=<?= $lot['id'] ?>"><?= htmlspecialchars($lot['name'], ENT_QUOTES) ?></a>
        </h3>
        <div class="lot__state">
            <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?= format_price($lot['price']) ?></span>
            </div>
            <div class="lot__timer timer">
                <?= format_period(time_left()) ?>
            </div>
        </div>
    </div>
</li>
  