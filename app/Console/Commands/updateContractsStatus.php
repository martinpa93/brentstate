<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Contract;
use App\Mail\DEndContract;

class updateContractsStatus extends Command
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
        dd($contracts);
        $contracts->each(function ($contract) {
            $reciever=$contract->user->email;
            $property=$contract->properties;
            $renter=$contract->renters;

            Mail::to($reciever)
            ->send(new DEndContract($property,$renter,$contract));
        });
       
    }
}
