<?php

namespace App\Modules;

use Exception;
use TelegramBot\Api\BotApi;

class Telegram
{
    public $bot;

    public function __construct()
    {
        $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
        $this->bot = $bot;
    }

    public function sendDocument($document, $chatId = null)
    {
        if (is_null($chatId)) {
            $chatId = env('TELEGRAM_CHANNEL_ID');
        }
        try {
            if (!file_exists($document)) {
                throw  new Exception("File doesn't exists");
            }
            $file = new \CURLFile($document);
            return $this->bot->sendDocument($chatId, $file);
        } catch (\TelegramBot\Api\HttpException $e) {
        }
    }
}
