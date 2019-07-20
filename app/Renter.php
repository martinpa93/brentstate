<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    protected $fillable = ['user_id','dni','name','surname','dbirth','address','cp','population'
                            ,"phone",'iban','job'];
    protected $hidden = ['created_at','updated_at'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    public function contracts()
    {
        return $this->hasMany("App\Contract","renter_id","dni");
    }

}