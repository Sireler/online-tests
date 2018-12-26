<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    public $timestamps = false;

    protected $fillable = ['text'];

    public function question()
    {
        return $this->belongsTo('App\SurveyQuestion');
    }
}
