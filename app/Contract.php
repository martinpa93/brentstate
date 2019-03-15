<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //

    protected $table = "contracts";
    
    public $keyType = 'string';
    public $autoincrement = false;

    protected $fillable = ['property_id','renter_id','dstart','dend','iva','watertax'
                            ,"gastax",'electriciytax','communitytax'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function properties()
    {
        return $this->belongsTo("App\Property", "property_id");
    }
    
    public function renters()
    {
        return $this->hasMany("App\Rent", "renter_id");
    }
}
