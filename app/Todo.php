<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['name','category','user_id','description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
