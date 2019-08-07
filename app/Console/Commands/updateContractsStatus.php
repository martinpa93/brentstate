<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Contract;

class UpdateContractsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:statusContracts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of the contracts every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today=Carbon::today();
        $contracts=\App\Contract::all();

        $contracts->each(function ($contract) use ($today) {
            $pipe = $contract->dstart;
            $pipe2 = $contract->dend;

            if ($today >= $pipe && $today < $pipe2) {
                $contract->status = true;
            } else $contract->status = false;
            $contract->save();
        });
       
    }
}
