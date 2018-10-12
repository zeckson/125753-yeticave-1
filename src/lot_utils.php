<?php
/**
 * @param $connection
 * @param $navigation
 * @param $lot_id
 * @param array $new_bid
 */
function render_lot_page($connection, $navigation, $lot, $new_bid = [
    'errors' => [],
    'bid' => []
])
{
    require_once 'src/bid_queries.php';
    $bids = get_all_bids_for_lot($connection, $lot['id']);


    $config = [
        'title' => 'Лот "' . $lot['name'] . '""',
        'content' => include_template('templates/lot', [
            'lot' => $lot,
            'bids' => $bids,
            'new_bid' => $new_bid
        ]),
        'navigation' => $navigation
    ];

    print include_template('templates/layout', $config);
}