<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['cref','user_id','address','population','province','cp','type'
                            ,"m2",'ac','nroom','nbath'];
    protected $hidden = ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function contracts()
    {
        return $this->hasMany("App\Contract","property_id","cref");
    }
}
