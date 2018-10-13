<?php
require_once 'src/form_utils.php';
?>
<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item <?= mark_if_true($category['id'] === $current, 'nav__item--current') ?>">
                <a href="lot_list.php?category=<?= $category['id'] ?>"><?= $category['name'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>