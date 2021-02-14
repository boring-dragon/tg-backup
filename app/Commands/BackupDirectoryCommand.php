<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Finder\Finder;
use App\Modules\Telegram;

class BackupDirectoryCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'backup:directory {dir : Path to the directory you want to backup}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Backup a directory to telegram';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dir = $this->argument('dir');
        $finder = new Finder();
        $bot = new Telegram;
        $finder->files()->in($dir);

        $zip = new \ZipArchive();

        $filename = "backup_" . \Carbon\Carbon::now()->format('YmdHis') . ".zip";
        $progressBar = $this->output->createProgressBar(count($finder));
        $progressBar->start();

        foreach ($finder as $file) {

            // open zip
            if ($zip->open($filename, \ZipArchive::CREATE) !== true) {
                throw new FileException('Zip file could not be created/opened.');
            }

            // add to zip
            $zip->addFile($file->getRealpath(), basename($file->getRealpath()));
            $progressBar->advance();

            // close zip
            if (!$zip->close()) {
                throw new FileException('Zip file could not be closed.');
            }
        }
        $progressBar->finish();

        $this->newLine();
        $this->info("Archive Completed");
        $this->info("Sending to telegram...");

        $bot->sendDocument($filename);
        //Remove the backup file
        unlink($filename);

        $this->info("All done!");
    }
}
