<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use App\Modules\Telegram;

class BackupASingleFileCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'backup:file {path_to_file : Path to the file you want to backup}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Backup a single file to telegram';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path_to_file = $this->argument('path_to_file');

        $bot = new Telegram;
        $bot->sendDocument( $path_to_file);
    }
}
