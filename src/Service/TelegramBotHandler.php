<?php


namespace App\Service;


use TelegramBot\Api\BotApi;

class TelegramBotHandler
{
    /**
     * @var BotApi
     */
    private $botApi;
    private $idUser;


    public function __construct(BotApi $botApi, $idUser)
    {
        $this->botApi = $botApi;
        $this->idUser = $idUser;
    }

    public function send(array $interestCurrency)
    {
        if ($interestCurrency) {
            $msg = '';
            foreach ($interestCurrency as $currency => $percent) {
                $msg .=  $currency . '->' . $percent . '; ';
            }
            $message = $this->botApi->sendMessage($this->idUser, $msg, 'markdown');
        }
    }

    public function test()
    {
        $this->botApi->sendMessage($this->idUser, 'test', 'markdown');
    }
}