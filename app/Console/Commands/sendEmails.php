<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Contract;
use App\Mail\DEndContract;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder end date of contracts';

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
        $range=Carbon::today()->addMonthsNoOverflow(2);
        $contracts=\App\Contract::whereDate('dend','>=',$today)
        ->whereDate('dend','<',$range)->get();
        $contracts->each(function ($contract) {
            $reciever=$contract->user->email;

            $property=$contract->properties;
            $renter=$contract->renters;
            Mail::to($reciever)
            ->send(new DEndContract($property,$renter,$contract));
        });
       
    }
}
