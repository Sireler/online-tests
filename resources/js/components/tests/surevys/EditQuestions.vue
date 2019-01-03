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
                            <tr v-for="(answer, i) in question.answers">
                                <td>{{ i + 1 }}</td>
                                <td>{{ answer.text }}</td>
                                <td><span class="oi oi-delete f" title="delete" aria-hidden="true"></span></td>
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

        },
        beforeCreate() {
            let id = this.$route.params.id;

            // Get info about survey
            this.axios.get(`/survey/get/${id}`)
                .then((res) => {
                    this.surveyName = res.data.survey[0].title;
                })
                .catch((err) => {
                    this.$toasted.show('Forbidden');
                    this.$router.push({ path: '/tests' });
                });

            // Get info about survey
            this.axios.get(`/survey/questions/get/${id}`)
                .then((res) => {
                    this.questions = res.data.questions;
                })
                .catch((err) => {
                    this.$toasted.show('Forbidden');
                    this.$router.push({ path: '/tests' });
                });
        }
    }
</script>

<style scoped>
    .oi-delete {
        color: #ff0000;
        font-size: 1.25em;
    }
</style>