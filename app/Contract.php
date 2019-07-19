<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    
    protected $fillable = ['property_id','renter_id','dstart','dend'];
    protected $hidden = ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo("App\User");
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
