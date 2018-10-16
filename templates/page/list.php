<?php
//       lot.id,
//       lot.name,
//       lot.description
//       start_price,
//       IFNULL(MAX(bid.amount), start_price) AS price,
//       image_url                            AS image,
//       category.name                        AS category,
//       count(bid.id)                        AS bids_count
/**
 * @var array $page
 * @var array $category
 */
require_once 'src/utils/lot.php';
?>
<div class="container">
    <section class="lots">
        <?php if (isset($query) && !empty($query)): ?>
            <?php if (sizeof($page['data']) <= 0): ?>
                <h2>По запросу «<span><?= html_saintize($query) ?></span>» ничего не найдено</h2>
            <?php else: ?>
                <h2>Результаты поиска по запросу «<span><?= html_saintize($query) ?></span>»</h2>
            <?php endif ?>
        <?php endif ?>
        <?php if (isset($category)): ?>
            <?php if (sizeof($page['data']) <= 0): ?>
                <h2>В категории <span>«<?= html_saintize($category['name']) ?>» ничего не найдено</span></h2>
            <?php else: ?>
                <h2>Все лоты в категории <span>«<?= html_saintize($category['name']) ?>»</span></h2>
            <?php endif ?>
        <?php elseif (!isset($query)): ?>
            <h2>Неизвестная категория</h2>
        <?php endif ?>

        <ul class="lots__list">
            <?php foreach ($page['data'] as $lot): ?>
                <?= include_template('templates/block/lot_card.php', ['lot' => $lot]) ?>
            <?php endforeach; ?>
        </ul>
    </section>
    <?= include_template('templates/block/pagination.php', ['page' => $page]) ?>
</div>
  