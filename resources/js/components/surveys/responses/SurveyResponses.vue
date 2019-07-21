<template>
    <div class="container">
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
    </div>
</template>

<script>
export default {
    name: "SurveyResponses",
    data() {
        return {
            questions: []
        }
    },
    methods: {
        getResponses() {
            this.axios.get(`/survey/votes/${this.id}/responses`)
                .then((res) => {
                    this.questions = res.data.questions;
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