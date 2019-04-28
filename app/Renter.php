<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    protected $table='renters';
    protected $primaryKey='dni';
    protected $keyType='string';
    public $incrementing = false;
    protected $fillable = ['dni','user_id','name','surname','dbirth','address','population'
                            ,"phone",'iban','job','salary'];
    protected $hidden = ['created_at','updated_at'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    
    public function contracts()
    {
        return $this->hasMany("App\Contract","renter_id","dni");
    }

}