<?php
require_once 'src/html_utils.php';
require_once 'src/links.php';
/**
 * @var array $current
 */
?>
<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item <?= mark_if_true($category === $current, 'nav__item--current') ?>">
                <a href="<?= get_category_page_link($category) ?>"><?= $category['name'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>