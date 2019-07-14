<?php

namespace Tests\Feature;

use App\Survey;
use App\SurveyQuestion;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testUserCanStoreQuestion()
    {
        $survey = factory(Survey::class)->create();

        $response = $this
            ->actingAs($survey->user, 'api')
            ->json('POST', 'api/survey/questions/create', [
                'survey_id' => $survey->id,
                'question' => [
                    'title' => 'QuestionTitle',
                    'type' => 'radio'
                ],
                'answers' => [
                    ['text' => 'Answer']
                ]
            ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'question',
                'message'
            ]);
    }

    public function testUnauthorizedUserCantStoreQuestion()
    {
        $response = $this->json('POST', 'api/survey/questions/create');
        $response->assertStatus(401);
    }

    public function testUserCantStoreQuestionForNotHisSurvey()
    {
        $user = factory(User::class)->create();
        $survey = factory(Survey::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->json('POST', 'api/survey/questions/create', [
                'survey_id' => $survey->id,
                'question' => [
                    'title' => 'QuestionTitle',
                    'type' => 'radio'
                ],
                'answers' => [
                    ['text' => 'Answer']
                ]
            ]);

        $response->assertStatus(403);
    }

    public function testUserCanUpdateQuestion()
    {
        $question = factory(SurveyQuestion::class)->create();

        $response = $this
            ->actingAs($question->survey->user, 'api')
            ->json('PATCH', 'api/survey/questions/update/' . $question->id, [
                'title' => 'New title'
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function testForbiddenUpdateQuestion()
    {
        $user = factory(User::class)->create();
        $question = factory(SurveyQuestion::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->json('PATCH', 'api/survey/questions/update/' . $question->id, [
                'title' => 'New title'
            ]);

        $response->assertStatus(403);
    }

    public function testDelteQuestion()
    {
        $question = factory(SurveyQuestion::class)->create();

        $response = $this->actingAs($question->survey->user, 'api')->json(
            'DELETE', 'api/survey/questions/delete/' . $question->survey->id . '/' . $question->id
        );

        $response->assertStatus(200);
    }

    public function testUserCantDeleteQuestion()
    {
        $user = factory(User::class)->create();
        $question = factory(SurveyQuestion::class)->create();

        $response = $this->actingAs($user, 'api')->json(
            'DELETE', 'api/survey/questions/delete/' . $question->survey->id . '/' . $question->id
        );

        $response->assertStatus(403);
    }
}
