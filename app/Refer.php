<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refer extends Model
{
    use HasFactory;

    public function userFunc(){
        return $this->belongsTo(User::class, 'referrer', 'id');
    }
}
