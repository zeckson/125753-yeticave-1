<?php
//       lot.id,
//       lot.name,
//       lot.description
//       start_price,
//       IFNULL(MAX(bid.amount), start_price) AS price,
//       image_url                            AS image,
//       category.name                        AS category,
//       count(bid.id)                        AS bids_count
/** @noinspection PhpIncludeInspection */
require_once 'src/lot_format.php';
?>
<div class="container">
    <section class="lots">
        <?php if (isset($category)): ?>
            <h2>Все лоты в категории <span>«<?= write_value($category['name']) ?>»</span></h2>
        <?php endif ?>

        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
                <?= include_template('templates/lot/lot_card.php', ['lot' => $lot]) ?>
            <?php endforeach; ?>
        </ul>
    </section>
    <!--<ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>-->
</div>
  