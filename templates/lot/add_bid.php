<?php
//       lot.id,
//       lot.name,
//       lot.description
//       start_price,
//       IFNULL(MAX(bid.amount), start_price) AS price,
//       image_url                            AS image,
//       category.id                          AS category,
//       count(bid.id)                        AS bids_count
/** @noinspection PhpIncludeInspection */
require_once 'src/form_utils.php';
$minimal_bid = $lot['price'] + $lot['bid_step'];
?>
<form class="lot-item__form <?= mark_if_true(!empty($errors), 'form--invalid') ?>"
      action="<?= get_add_bid_page_link($lot['id']) ?>" method="post" enctype="application/x-www-form-urlencoded">
    <p class="lot-item__form-item <?= mark($errors['amount']) ?>">
        <label for="cost">Ваша ставка</label>
        <input id="cost" type="number" name="amount" value="<?= write_value($bid['amount']) ?>"
               placeholder="<?= format_price($minimal_bid) ?>">
        <span class="form__error"><?= write_value($errors['amount']) ?></span>
    </p>
    <button type="submit" class="button">Сделать ставку</button>
</form>
