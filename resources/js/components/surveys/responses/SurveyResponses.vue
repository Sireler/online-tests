<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <router-link :to="{ name: 'surveys.edit', params: { id: id } }">
                        Back to the survey
                    </router-link>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Responses</h4>

                        <div class="questions mb-2" v-for="question in questions">
                            <div class="question-title p-2 bg-info text-primary rounded mb-2">
                                Question: {{ question.title }}
                            </div>

                            <div class="answers ml-4">
                                <div class="answer-item" v-for="(answer,i) in question.answers">
                                    Answer ({{ i+1 }}): {{ answer.text }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div v-for="a in analyze">
                            <div class="question-title" v-if="rendered[a.question.id] === undefined">
                                Question: {{ checkQuestion(a) }}
                            </div>
                            <span class="text-success ml-4">
                                {{ a.question.title }} : {{ a.answer.text }} ({{ a.answers_count }})
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SurveyResponses",
    data() {
        return {
            questions: [],
            analyze: [],
            rendered: []
        }
    },
    methods: {
        getResponses() {
            this.axios.get(`/survey/votes/${this.id}/responses`)
                .then((res) => {
                    this.questions = res.data.questions;
                    this.analyze = res.data.analyze;
                })
                .catch((err) => {
                    this.$toasted.show('Forbidden');
                });
        },
        checkQuestion(a) {
            this.rendered[a.question.id] = 1;

            return a.question.title;
        }
    },
    computed: {
        id() {
            return this.$route.params.id;
        }
    },

    mounted() {
        this.getResponses();
    }
}
</script>

<style scoped>

</style>