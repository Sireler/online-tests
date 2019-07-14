<?php

namespace App\Policies;

use App\User;
use App\SurveyQuestion as Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the question.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyQuestion  $question
     * @return mixed
     */
    public function view(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can create questions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the question.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyQuestion  $question
     * @return mixed
     */
    public function update(User $user, Question $question)
    {
        $question = $user->surveys()->whereHas('questions', function($query) use($question) {
            $query->where('id', '=', $question->id);
        })->get();

        return $question->isNotEmpty();
    }

    /**
     * Determine whether the user can delete the question.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyQuestion  $question
     * @return mixed
     */
    public function delete(User $user, Question $question)
    {
        $question = $user->surveys()->whereHas('questions', function($query) use($question) {
            $query->where('id', '=', $question->id);
        })->get();

        return $question->isNotEmpty();
    }

    /**
     * Determine whether the user can restore the question.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyQuestion  $question
     * @return mixed
     */
    public function restore(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the question.
     *
     * @param  \App\User  $user
     * @param  \App\SurveyQuestion  $question
     * @return mixed
     */
    public function forceDelete(User $user, Question $question)
    {
        //
    }
}
