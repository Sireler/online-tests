<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'type'];

    public function survey()
    {
        return $this->belongsTo('App\Survey');
    }
}
