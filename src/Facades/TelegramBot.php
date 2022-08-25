<?php

namespace Gmedia\IspSystem\Facades;

use Carbon\Carbon;
use Telegram\Bot\Api;

class TelegramBot
{
    public static function sendSentryMessage($error = [], $tags = [])
    {
        if (!config('telegram.setry')) return false;

        $projectName = config('telegram.project_name');
        $chatId = config('telegram.sentry_chat_id');

        $telegram = new Api(config('telegram.bot_token'), true);

        $text = '[<b>'.$projectName.'</b>] ['.Carbon::now()->format('Y-m-d H:i:s').']'.PHP_EOL
            .'Message : <b>'.$error['message'].'</b>'.PHP_EOL
            .'Location : <code>'.$error['file'].':'.$error['line'].'</code>';

        if ($tags) {
            $tag_text = PHP_EOL;
            foreach ($tags as $tag) $tag_text = $tag.' '.$tag_text;
            $text = $tag_text.$text;
        }

        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
    }

    public static function sendMessage($chatId, $text, $tags = [])
    {
        $telegram = new Api(config('telegram.bot_token'), true);

        if ($tags) {
            $tag_text = PHP_EOL;
            foreach ($tags as $tag) $tag_text = $tag.' '.$tag_text;
            $text = $tag_text.$text;
        }

        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);
    }
}
