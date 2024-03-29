<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    
    protected $fillable = ['user_id','property_id','renter_id','dstart','dend','status'];
    protected $hidden = ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo("App\User","user_id","id");
    }

    public function properties()
    {
        return $this->belongsTo("App\Property", "property_id", "cref");
    }
    
    public function renters()
    {
        return $this->belongsTo("App\Renter", "renter_id", "dni");
    }
}
