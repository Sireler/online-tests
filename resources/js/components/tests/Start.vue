<template>
    <div class="container" v-if="survey != null">
        <div class="alert alert-info">
            <h4>Survey name: {{ survey.title }}</h4>
            <hr>
            <p>Question {{ current + 1 }} of {{ questionsCount }}</p>
        </div>
        <div class="card border-secondary ">
            <div class="card-header bg-primary text-white">
                Question: {{ survey.questions[current].title }}
            </div>
            <div class="card-body">
                <div class="form-group" v-for="(answer, i) in survey.questions[current].answers">
                    <input :value="answer.id"
                           v-model="selectedAnswer"
                           type="radio"
                           :id="'a' + i">
                    <label :for="'a' + i">
                        {{ i + 1 }}) {{ answer.text }}
                    </label>
                </div>
            </div>
        </div>
        <button class="btn btn-next btn-outline-primary"
                @click="nextQuestion">
            Next
        </button>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data() {
        return {
            survey: null,
            current: 0,
            selectedAnswer: 0,
            userAnswers: []
        }
    },
    methods: {
        loadSurvey() {
            this.$parent.showLoading();
            this.axios.get(`/survey/start/${this.$route.params.id}`)
                .then((res) => {
                    this.$parent.hideLoading();
                    this.survey = res.data.survey;
                })
                .catch((err) => {
                    this.$router.push({ path: `/home` });
                    this.hideLoading();
                    this.$toasted.show('Request error');
                });
        },
        nextQuestion(e) {
            this.userAnswers[this.current] = {
                'survey_id': this.$route.params.id,
                'survey_question_id': this.survey.questions[this.current].id,
                'survey_answer_id': this.selectedAnswer
            };

            if (this.questionsCount == (this.current + 2)) {
                e.target.innerHTML = 'Finish';
            }

            if (this.questionsCount == (this.current + 1)) {
                this.submit();
                return;
            }

            this.selectedAnswer = 0;
            this.current++;
        },
        submit() {
            this.axios.post(`/survey/votes`, {
                'data': this.userAnswers
            }).then((res) => {
                this.$toasted.show(res.data.message);
            }).catch((err) => {
                this.$toasted.show('Save failed');
            });
        },
    },
    computed: {
        questionsCount() {
            return Object.keys(this.survey.questions).length;
        }
    },
    mounted() {
        this.loadSurvey();
    }
}
</script>

<style scoped>
.card-header {
    background-color: #007BFF;
    color: #fff;
}
.card {
    border-color: #007BFF;
}
.btn-next {
    margin-top: 15px;
}
</style>