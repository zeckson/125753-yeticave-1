<?php
/**
 * @var array $bids
 * @var array $category
 */
require_once 'src/utils/html.php';
require_once 'src/utils/lot.php';

function get_state($bid)
{
    if ($bid['has_won']) {
        return 'won';
    }
    if (strtotime($bid['lot_closed_at']) < time() || $bid['lot_winner']) {
        return 'finished';
    }
    return 'active';
}

?>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($bids as $bid): ?>
            <?php
            $state_2_title = [
                'active' => format_period(time_left($bid['lot_closed_at'])),
                'won' => 'Ставка выиграла',
                'finished' => 'Торги окончены'
            ];
            $state = get_state($bid);
            ?>
            <tr class="rates__item
            <?= mark_if_true($state === 'won', 'rates__item--win') ?>
            <?= mark_if_true($state === 'finished', 'rates__item--end') ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= $bid['lot_image'] ?>" width="54" height="40"
                             alt="<?= write_value($bid['lot_name']) ?>">
                    </div>
                    <div>
                        <h3 class="rates__title"><a
                                    href="<?= get_lot_page_link_by_id($bid['lot_id']) ?>"><?= write_value($bid['lot_name']) ?></a>
                        </h3>
                        <?php if ($state === 'won'): ?>
                            <p><?= write_value($bid['author_contact']) ?></p>
                        <?php endif ?>
                    </div>
                </td>
                <td class="rates__category">
                    <?= write_value($bid['lot_category']) ?>
                </td>
                <td class="rates__timer">
                    <div class="timer
                    <?= mark_if_true($state === 'won', 'timer--win') ?>
                    <?= mark_if_true($state === 'finished', 'timer--end') ?>"
                    ><?= $state_2_title[$state] ?></div>
                </td>
                <td class="rates__price">
                    <?= format_price($bid['amount']) ?>
                </td>
                <td class="rates__time">
                    <?= format_relative_time(strtotime($bid['created_at'])) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
  