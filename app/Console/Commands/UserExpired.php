<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UserExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update User Mendjadi Expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
