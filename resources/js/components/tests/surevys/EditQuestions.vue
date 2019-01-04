<template>
    <div class="container">

        <!--survey info-->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-primary border-secondary mb-3 text-white" >
                    <div class="card-header">Survey: {{ surveyName }}</div>
                    <div class="card-body">
                        <p class="card-text">Questions: {{ questions.length }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!--questions and answers-->
        <div id="accordion">
            <div class="card"
                 v-for="(question, i) in questions">
                <div class="card-header" :id="`heading${i}`">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" :data-target="`#collapse${i}`" aria-expanded="true" :aria-controls="`collapse${i}`">
                            {{ question.title }}
                        </button>
                        <span class="oi oi-circle-x float-right" title="delete question" aria-hidden="true"
                              @click="questionDelete(i, question.id)"></span>
                    </h5>
                </div>

                <div :id="`collapse${i}`" class="collapse" :aria-labelledby="`heading${i}`" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <caption>Answers</caption>
                            <tr>
                                <th>#</th>
                                <th>Text</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="(answer, ai) in question.answers">
                                <td>{{ ai + 1 }}</td>
                                <td>{{ answer.text }}</td>
                                <td><span class="oi oi-delete" title="delete answer" aria-hidden="true"
                                     @click="answerDelete(i, ai, answer.id)"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                surveyName: '',
                questions: [],
            }
        },
        methods: {
            answerDelete(questionIndex, answerIndex, answerId) {
                let surveyId = this.$route.params.id;

                this.axios.delete(`/survey/answers/${surveyId}/${answerId}`)
                    .then((res) => {
                        // delete answer from array
                        this.questions[questionIndex].answers.splice(answerIndex, 1);

                        this.$toasted.show(res.data.message);
                    })
                    .catch((err) => {
                        this.$toasted.show('Forbidden');
                    });
            },
            questionDelete(questionIndex, questionId) {
                let surveyId = this.$route.params.id;

                this.axios.delete(`/survey/questions/delete/${surveyId}/${questionId}`)
                    .then((res) => {
                        // delete question from array
                        this.questions.splice(questionIndex, 1);

                        this.$toasted.show(res.data.message);
                    })
                    .catch((err) => {
                        this.$toasted.show('Forbidden');
                    });
            }
        },
        beforeCreate() {
            let id = this.$route.params.id;

            // Get info about survey
            this.axios.get(`/survey/questions/get/${id}`)
                .then((res) => {
                    this.questions = res.data.questions;
                    this.surveyName = res.data.title;
                })
                .catch((err) => {
                    this.$toasted.show('Forbidden');
                    this.$router.push({ path: '/tests' });
                });
        }
    }
</script>

<style scoped>
.oi {
    font-size: 1.15em;
}
.oi-circle-x {
    color: #ff0000;
}
.oi-wrench {
    color: #29ab0f;
}
</style>