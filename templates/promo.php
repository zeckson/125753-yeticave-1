<?php
function get_category_class($category)
{
    $category_2_class = [
        'доски и лыжи' => 'boards',
        'крепления' => 'attachment', // bindings
        'ботинки' => 'boots',
        'одежда' => 'clothing', // outfits, clothes, dress
        'инструменты' => 'tools',
        'разное' => 'other',
    ];

    $name = mb_strtolower($category['name'], 'utf-8');
    return $category_2_class[$name];
}

?>
<ul class="promo__list">
    <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--<?= get_category_class($category) ?>">
            <a class="promo__link" href="pages/all-lots.html"><?= $category['name'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>