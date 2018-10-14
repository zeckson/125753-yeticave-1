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
require_once 'src/utils/html.php';

$is_win = true;
function get_state($lot)
{
    if($is_win) {
        return 'Ставка выиграла';
    }
    if($lot['closed_at'] < time() && $lot['winner_id']) {
        return 'Торги окончены';
    }
    return format_period(time_left($lot['closed_at']));
}
?>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <tr class="rates__item <?= mark_if_true($is_win, 'rates__item--win') ?> rates__item--end">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?= $lot['image'] ?>" width="54" height="40" alt="<?= write_value($lot['name']) ?>">
                </div>
                <div>
                    <h3 class="rates__title"><a
                                href="<?= get_lot_page_link_by_id($lot['id']) ?>"><?= write_value($lot['description']) ?></a>
                    </h3>
                    <?php if ($is_win): ?>
                        <p><?= write_value($lot['author_contact']) ?></p>
                    <?php endif ?>
                </div>
            </td>
            <td class="rates__category">
                <?= write_value($lot['category']) ?>
            </td>
            <td class="rates__timer">
                <div class="timer <?= mark_if_true($is_win, 'timer--win') ?> timer--end"><?= get_state($lot) ?></div>
            </td>
            <td class="rates__price">
                <?= format_price($lot['bid_amount']) ?>
            </td>
            <td class="rates__time">
                <?= format_relative_time($lot['bid_time']) ?>
            </td>
        </tr>
    </table>
</section>
  