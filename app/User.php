<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function surveys()
    {
        return $this->hasMany('App\Survey');
    }

    /**
     * Check user access to survey
     *
     * @param $id
     * @return bool
     */
    public function hasSurvey($id)
    {
        $survey = $this->surveys()->where('id', '=', $id)->get();

        return $survey->isNotEmpty();
    }

    /**
     * Check user access to question
     *
     * @param $id
     * @return bool
     */
    public function hasQuestion($id)
    {
        $question = $this->surveys()->whereHas('questions', function($query) use($id) {
            $query->where('id', '=', $id);
        })->get();

        return $question->isNotEmpty();
    }

    /**
     * Check user access to answer
     *
     * @param $id
     * @return bool
     */
    public function hasAnswer($id)
    {
        $answer = $this->surveys()->whereHas('questions', function($query) use($id) {
            $query->whereHas('answers', function($q) use ($id) {
                $q->where('id', '=', $id);
            });
        })->get();

        return $answer->isNotEmpty();
    }
}
