<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChargeGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:charge-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manual Charges Generate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(
            new \App\Jobs\ChargeGenerate()
        );
    }
}
