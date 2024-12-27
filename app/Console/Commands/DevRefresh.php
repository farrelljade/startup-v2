<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DevRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all development caches and routes';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Refreshing development environment...');

        $this->call('optimize:clear');
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('route:clear');
        $this->call('route:cache');
        $this->call('config:cache');

        $this->info('All caches have been refreshed!');

        return Command::SUCCESS;
    }
}
