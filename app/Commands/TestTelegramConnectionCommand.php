<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use TelegramBot\Api\BotApi;

class TestTelegramConnectionCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'test:telegram';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Test the telegram connection';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!(env('TELEGRAM_BOT_TOKEN') && env('TELEGRAM_CHANNEL_ID'))) {
            $this->error('Invalid Configurations!.. Please check if your environment file is set correctly');
            return Command::FAILURE;
        }
        $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
        $bot->sendMessage(env('TELEGRAM_CHANNEL_ID'), "This is a test message from tg-backup app");

        $this->info("Testing.. Check your telegram channel.");
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
