<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Contract;
use App\Notification;
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
    protected $description = 'Reminder end date of contracts and insert on DB';

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
        $contracts->each(function ($contract)
        {
            //create
            Notification::create([
                'user_id' => $contract->user->id,
                'contract_id' => $contract->id,
                'priority' => 'high' ,
                'event' => 'FIN DE CONTRATO',
                'description' => 'Fin de contrato para la propiedad '.$contract->properties->address.' el '.$contract->dend
            ]);
            

            $reciever=$contract->user->email;
            
            $property=$contract->properties;
            $renter=$contract->renters;
            Mail::to($reciever)
            ->send(new DEndContract($property,$renter,$contract));
        });
       
    }
}
