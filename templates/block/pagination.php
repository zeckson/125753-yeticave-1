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