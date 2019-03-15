<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    //
    protected $table = "renters";
    protected $primaryKey = 'dni';
    public $keyType = 'string';
    public $autoincrement = false;

    protected $fillable = ['dni','name','surname','dbirth','address','population'
                            ,"phone",'creditcard','job','salary'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function contracts()
    {
        return $this->hasMany("App\Contract","renter_id","dni");
    }

}