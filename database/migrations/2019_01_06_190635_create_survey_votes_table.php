<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('survey_id');
            $table->unsignedInteger('survey_question_id');
            $table->unsignedInteger('survey_answer_id');
            $table->foreign('survey_id')
                ->references('id')->on('surveys');
            $table->foreign('survey_question_id')
                ->references('id')->on('survey_questions');
            $table->foreign('survey_answer_id')
                ->references('id')->on('survey_answers');
            $table->ipAddress('ip');
            $table->string('userAgent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_votes');
    }
}
