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
        <?php if (isset($category)): ?>
            <h2>Все лоты в категории <span>«<?= write_value($category['name']) ?>»</span></h2>
        <?php endif ?>

        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
                <?= include_template('templates/block/lot_card.php', ['lot' => $lot]) ?>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php if ($page['total'] > 1): ?>
        <ul class="pagination-list">
            <?php if ($page['current'] > 1): ?>
                <li class="pagination-item pagination-item-prev">
                    <a href="<?= get_category_page_link($category ?? null, $page['current'] - 1) ?>">Назад</a>
                </li>
            <?php endif ?>

            <?php for ($i = 1; $i < $page['total'] + 1; $i++): ?>
                <?php if ($i === $page['current']): ?>
                    <li class="pagination-item pagination-item-active"><a><?= $i ?></a></li>
                <?php else: ?>
                    <li class="pagination-item"><a
                                href="<?= get_category_page_link($category ?? null, $i) ?>"><?= $i ?></a></li>
                <?php endif ?>
            <?php endfor ?>
            <?php if ($page['current'] < $page['total']): ?>
                <li class="pagination-item pagination-item-next">
                    <a href="<?= get_category_page_link($category ?? null, $page['current'] + 1) ?>">Вперёд</a>
                </li>
            <?php endif ?>
        </ul>
    <?php endif ?>
</div>
  