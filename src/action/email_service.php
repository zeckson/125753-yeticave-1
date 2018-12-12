<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
const BASE_URL = 'http://localhost:8080';
const IS_EMAIL_ENABLED = false;

/**
 * @return Swift_Mailer
 */
function setup_mailer(): Swift_Mailer
{
    $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
    $transport->setUsername("keks@phpdemo.ru");
    $transport->setPassword("htmlacademy");

    return new Swift_Mailer($transport);
}

/**
 * @param Swift_Mailer $mailer
 * @param array $recipient
 * @param array $lot
 * @return null|string
 */
function send_email_to_winner(Swift_Mailer $mailer, array $recipient, array $lot): ?string
{

    $logger = new Swift_Plugins_Loggers_ArrayLogger();
    $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

    $message = new Swift_Message();
    $message->setSubject("[YetiCave] Ваша ставка выиграла");
    $message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);
    $message->setTo([$recipient['email'] => $recipient['name']]);

    $msg_content = include_template('templates/email/winner.php', ['user' => $recipient, 'lot' => $lot]);
    $message->setBody($msg_content, 'text/html');

    $result = $mailer->send($message);

    if ($result) {
        return null;
    } else {
        return $logger->dump();
    }
}