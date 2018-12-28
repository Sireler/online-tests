<template>
    <div class="container">
        <!-- Edit info -->
        <div class="jumbotron">
            <form @submit.prevent>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-10">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control"
                                   :disabled="!editFields"
                                   v-model="title">
                        </div>
                        <div class="col-md-2 mt-3 mt-md-0"
                             v-show="!editFields">
                            <button class="btn btn-secondary btn-block"
                                    @click="edit">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-10 text-right"
                             v-show="editFields">
                            <a @click.prevent="cancelEdit" class="edit-link" href="">Cancel</a>
                            <button class="btn btn-success"
                                    @click="save">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row mb-4">
            <div class="col-md-6" v-for="question in questions">
                <div class="card border-primary mb-3" >
                    <div class="card-header">{{ question.title }}</div>
                    <div class="card-body text-primary">
                        <h5 class="card-title"><a href="#">Show answers</a></h5>
                        <p class="card-text">Answers: {{ question.answers.length }}</p>
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
                title: '',
                stTitle: '',
                editFields: false,

                questionTitle: '',

                type: 'Multiple choice',
                inputsType: 'radio',
                answers: [
                    {
                        text: ''
                    }
                ],
                maxAnswers: 10,


                // new component --no del
                questions: [],


            }
        },
        methods: {
            edit() {
                this.editFields = true;
            },
            cancelEdit() {
                this.editFields = false;
                this.title = this.stTitle;
            },
            save() {
                let id = this.$route.params.id;

                // Update survey fields
                this.axios.patch(`/survey/update/${id}`, {
                    'title': this.title
                }).then((res) => {
                    this.$toasted.show(res.data.message);
                    this.stTitle = this.title;
                    this.cancelEdit();
                }).catch((err) => {
                    this.$toasted.show('Error');
                });
            },

            generateByType(e) {
                let select = e.target;

                this.type = select.value;
                this.inputsType = select.options[select.selectedIndex].value;
            },
            addAnswer() {
                if (this.answers.length < this.maxAnswers) {
                    this.answers.push({text: ''});
                } else {
                    this.$toasted.show(`Maximum number of answers: ${this.maxAnswers}`);
                }
            },
            removeAnswer() {
                if (this.answers.length > 1) {
                    this.answers.pop();
                }
            },

            storeAll() {
                this.axios.post(`/survey/questions/create`, {
                    'survey_id': this.$route.params.id,
                    'question': {
                        title: this.questionTitle,
                        type: this.inputsType
                    },
                    'answers': this.answers
                }).then((res) => {
                    this.$toasted.show(res.data.message);
                }).catch((err) => {
                    this.$toasted.show('Error');
                });
            }
        },
        beforeCreate() {
            let id = this.$route.params.id;

            // Get info about survey
            this.axios.get(`/survey/get/${id}`)
                .then((res) => {
                    this.title = this.stTitle = res.data.survey[0].title;
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
    .jumbotron {
        background-color: #EAF0F5;
    }
    .edit-link {
        color: #0f070f;
        margin: 0 25px;
    }
    .create-question {
        border-top: 2px solid #fff;
        border-bottom: 2px solid #fff;
        padding: 15px;
        margin: 10px 0;
    }
    .input-group-text {
        background-color: #A976C3;
    }
    .answers {
        margin: 10px 0;
    }
    .answers-item {
        margin: 5px 0;
    }
</style>