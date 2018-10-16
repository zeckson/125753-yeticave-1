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
require_once 'src/utils/links.php';
?>
<li class="lots__item lot">
    <div class="lot__image">
        <img src="<?= $lot['image'] ?>" width="350" height="260"
             alt="<?= html_saintize($lot['name']) ?>">
    </div>
    <div class="lot__info">
        <span class="lot__category"><?= html_saintize($lot['category']) ?></span>
        <h3 class="lot__title"><a class="text-link"
                                  href="<?= get_lot_page_link_by_id($lot['id']) ?>"><?= html_saintize($lot['name']) ?></a>
        </h3>
        <div class="lot__state">
            <div class="lot__rate">
                <span class="lot__amount">Цена</span>
                <span class="lot__cost"><?= format_price($lot['price']) ?></span>
            </div>
            <div class="lot__timer timer <?= mark_if_true(lot_is_finishing(time_left($lot['closed_at'])), 'timer--finishing') ?>">
                <?= format_period(time_left($lot['closed_at'])) ?>
            </div>
        </div>
    </div>
</li>
  