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
                    <h3 class="p-3">Number of responses: {{ votes.length }}</h3>
                    <div class="card-body">
                        <div class="votes">
                            <div class="vote-item" v-for="(vote, i) in votes">
                                Response {{ i + 1}}
                            </div>
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
            votes: []
        }
    },
    methods: {
        getResponses() {
            this.axios.get(`/survey/votes/${this.id}/responses`)
                .then((res) => {
                    this.questions = res.data.questions;
                    this.votes = res.data.votes;
                })
                .catch((err) => {
                    this.$toasted.show('Forbidden');
                });
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