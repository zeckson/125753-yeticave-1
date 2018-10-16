<?php
declare(strict_types=1);
require_once 'src/action/email_service.php';
require_once 'src/bid_queries.php';
require_once 'src/user_queries.php';

/**
 * @param mysqli $connection
 */
function determine_winner(mysqli $connection):void
{
    $mailer = setup_mailer();
    $expired_lots = get_all_expired_lots_without_winner($connection);
    foreach ($expired_lots as $lot) {

        $bids = get_all_bids_for_lot($connection, $lot['id']);
        if (sizeof($bids) > 0) {
            $winner_id = $bids[0]['owner_id'];
            set_lot_winner($connection, $lot['id'], $winner_id);
            $user = get_user_by_id($connection, $winner_id);
            $error = send_email_to_winner($mailer, $user, $lot);
            if ($error) {
                print "Не удалось отправить письмо {$user['email']}: $error";
                break;
            }
        }
    }
}