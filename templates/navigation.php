<?php
require_once 'src/form_utils.php';
require_once 'src/links.php';
?>
<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item <?= mark_if_true($category['id'] === $current, 'nav__item--current') ?>">
                <a href="<?= get_category_link($category) ?>"><?= $category['name'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>