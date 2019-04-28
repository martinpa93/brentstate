<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Property;
use App\Renter;
use App\Contract;
use Illuminate\Support\Collection;

class DEndContract extends Mailable
{
    use Queueable, SerializesModels;

    public $property;
    public $renter;
    public $contract;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( Property $property
                                ,Renter $renter
                                ,Contract $contract)
    {
        $this->property = $property;
        $this->renter = $renter;
        $this->contract = $contract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rentstate: Fin de contrato de '.$this->renter->name.' '.$this->renter->surname)->view('dendemail');
    }
}
