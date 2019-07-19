<template>
    <div class="container">
        <!--questions and answers-->
        <div id="accordion">
            <div class="card"
                 v-for="(question, i) in questions">
                <div class="card-header" :id="`heading${i}`">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" :data-target="`#collapse${i}`"
                                aria-expanded="true" :aria-controls="`collapse${i}`">
                            {{ question.title }}
                            <span class="oi oi-arrow-bottom ml-2"></span>
                        </button>
                        <span class="oi oi-circle-x float-right" title="Delete this question" aria-hidden="true"
                              @click="questionDelete(i, question.id)"></span>
                        <span class="oi oi-wrench float-right mr-2" title="Edit this question" aria-hidden="true"
                              @click="questionEdit(i, question)" ></span>
                    </h5>
                </div>

                <div :id="`collapse${i}`" :class="`collapse ${i === 0 ? 'show' : ''}`"
                     :aria-labelledby="`heading${i}`" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table bg-white">
                            <caption>Answers</caption>
                            <tr>
                                <th>#</th>
                                <th>Text</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="(answer, ai) in question.answers">
                                <td>{{ ai + 1 }}</td>
                                <td>{{ answer.text }}</td>
                                <td>
                                    <span class="oi oi-delete" title="Delete this answer" aria-hidden="true"
                                     @click="answerDelete(i, ai, answer.id)"></span>
                                </td>
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
                this.$dialogs.confirm('Are you sure you want to delete an answer?', {
                    title: 'Delete answer', okLabel: 'Delete'
                }).then(res => {
                    if (res.ok) {
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
                    }
                });
            },
            questionDelete(questionIndex, questionId) {
                this.$dialogs.confirm('Are you sure you want to delete a question?', {
                    title: 'Delete question', okLabel: 'Delete'
                }).then(res => {
                    if (res.ok) {
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
                });
            },
            questionEdit(questionIndex, question) {
                this.$emit('editQuestion', question);
            },

            addItem(item) {
                this.questions.push(item);
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
                    this.$router.push({ name: 'surveys' });
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
.oi-arrow-bottom {
    font-size: 0.9em;
}
</style>