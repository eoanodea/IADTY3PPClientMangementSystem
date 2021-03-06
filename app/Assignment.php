<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public function client() {
        return $this->belongsTo('App\User');
    }
    public function service() {
        return $this->belongsTo('App\Service');
    }
    public function task() {
        return $this->hasMany('App\ActiveTask');
    }
}
