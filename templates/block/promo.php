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

require_once 'src/utils/links.php';
?>
<ul class="promo__list">
    <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--<?= get_category_class($category) ?>">
            <a class="promo__link" href="<?= get_category_page_link($category) ?>"><?= $category['name'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>