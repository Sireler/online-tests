<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyVote extends Model
{
    protected $fillable = ['ip', 'userAgent'];

    public function answer()
    {
        return $this->belongsTo('App\SurveyAnswer');
    }

    public function survey()
    {
        return $this->belongsTo('App\Survey');
    }

    public function question()
    {
        return $this->belongsTo('App\SurveyQuestion');
    }
}
