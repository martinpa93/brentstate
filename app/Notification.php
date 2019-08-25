<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'contract_id','priority','event','description'];
    protected $hidden = ['created_at','updated_at'];
    
    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
