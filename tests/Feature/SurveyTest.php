<?php

namespace Tests\Feature;

use App\Survey;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testGetUserSurveys()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('SecretPass')
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', 'api/survey/index');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'surveys'
            ]);
    }

    public function testGetSurveysThatHaveAtLeastOneQuestion()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('SecretPass')
        ]);

        $surveyWith = $user->surveys()->create([
            'title' => 'surveyWithQuestions'
        ]);
        $surveyWith->questions()->create([
            'title' => $this->faker->title,
            'type' => 'radio'
        ]);

        $surveyWithout = $user->surveys()->create([
            'title' => 'surveyWithoutQuestions'
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', 'api/survey/home');

        $response
            ->assertStatus(200)
            ->assertJson([
                'surveys' => [$surveyWith->toArray()]
            ]);
    }

    public function testGetSurveysWithQuestionsAndAnswers()
    {
        $survey = factory(Survey::class)->create();

        $response = $this->json('GET', 'api/survey/start/' . $survey->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'survey' => [
                    'questions' => []
                ]
            ]);
    }

    public function testUserCanDeleteSurvey()
    {
        $user = factory(User::class)->create();
        $survey = $user->surveys()->save(factory(Survey::class)->make());


        $response = $this->actingAs($user, 'api')
                        ->json('DELETE', 'api/survey/delete/' . $survey->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Survey deleted'
            ]);
    }

    public function testUserCantDeleteSurvey()
    {
        $survey = factory(Survey::class)->create();

        $response = $this->json('DELETE', 'api/survey/delete/' . $survey->id);

        $response->assertStatus(401);
    }

    public function testUserCanUpdateSurvey()
    {
        // User is owner of this survey
        // Survey must be deleted
        $user = factory(User::class)->create();
        $survey = $user->surveys()->save(factory(Survey::class)->make());

        $response = $this->actingAs($user, 'api')
            ->json('PATCH', 'api/survey/update/' . $survey->id);

        $response->assertStatus(202);
    }

    public function testUserCantUpdateSurvey()
    {
        // User is not owner of this survey
        // Survey cannot be deleted
        $user = factory(User::class)->create();
        $survey = factory(Survey::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('PATCH', 'api/survey/update/' . $survey->id);

        $response->assertStatus(403);
    }
}
