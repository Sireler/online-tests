<?php

namespace Tests\Feature;

use App\Survey;
use App\SurveyAnswer;
use App\SurveyQuestion;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerTest extends TestCase
{
    public function testUserCanUpdateHisOwnAnswers()
    {
        $question = factory(SurveyQuestion::class)->create();
        $answer = $question->answers()->save(factory(SurveyAnswer::class)->make());

        $response = $this
            ->actingAs($question->survey->user)
            ->json('POST', 'api/survey/answers/update/' . $question->id, [
                'answers' => [$answer]
            ]);

        $response->assertStatus(200);
    }

    public function testUserCantUpdateAnswers()
    {
        $user = factory(User::class)->create();
        $question = factory(SurveyQuestion::class)->create();
        $answer = $question->answers()->save(factory(SurveyAnswer::class)->make());

        $response = $this
            ->actingAs($user)
            ->json('POST', 'api/survey/answers/update/' . $question->id, [
                'answers' => [$answer]
            ]);

        $response->assertStatus(403);
    }

    public function testUserCanDeleteHisOwnAnswer()
    {
        $question = factory(SurveyQuestion::class)->create();
        $answer = $question->answers()->save(factory(SurveyAnswer::class)->make());

        $response = $this
            ->actingAs($question->survey->user)
            ->json('DELETE', 'api/survey/answers/' . $question->survey->id . '/' . $answer->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Answer deleted'
            ]);
    }

    public function testUserCantDeleteAnswer()
    {
        $user = factory(User::class)->create();
        $question = factory(SurveyQuestion::class)->create();
        $answer = $question->answers()->save(factory(SurveyAnswer::class)->make());

        $response = $this
            ->actingAs($user)
            ->json('DELETE', 'api/survey/answers/' . $question->survey->id . '/' . $answer->id);

        $response->assertStatus(403);
    }
}
