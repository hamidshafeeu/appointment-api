<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\AbstractProcessingHandler;

class BotLogger extends AbstractProcessingHandler {

    protected function write(array $record): void
    {
        Http::withHeaders([
            'content-type' => 'application/json'
        ])->post( config('services.discord_bot.webhook'), [
            'content' => $record['message'],
        ]);
    }

}