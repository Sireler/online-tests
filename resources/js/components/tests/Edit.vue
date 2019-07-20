<template>
    <div class="container">
        <!-- Edit info -->
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="jumbotron">
                    <form @submit.prevent>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="title">Title</label>
                                    <input id="title" type="text" class="form-control"
                                           :disabled="!editFields"
                                           v-model="title">
                                </div>
                                <div class="col-md-6">
                                    <label for="surveyType">Type</label>
                                    <select class="form-control" id="surveyType" v-model="type" :disabled="!editFields">
                                        <option value="public">Public</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4"
                                     v-show="!editFields">
                                    <button class="btn btn-primary btn-block"
                                            @click="edit">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 text-right"
                                     v-show="editFields">
                                    <a @click.prevent="cancelEdit" class="edit-link" href="">Cancel</a>
                                    <button class="btn btn-success"
                                            @click="save">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- View responses button -->
        <div class="row my-2">
            <div class="col-md-10 offset-md-1">
                <router-link class="btn btn-block btn-success"
                             :to="{ name: 'surveys.responses', props: { id: id } }">
                    View responses
                </router-link>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-1">
                <div class="jumbotron">
                    <h3>{{ editModeText }}</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="create-question">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="question-title">Title:</label>
                                            <input id="question-title" type="text" class="form-control" placeholder="Question title"
                                                   v-model="questionTitle">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group inline">
                                            <label for="type">Type:</label>
                                            <select class="form-control" id="type"
                                                    v-model="inputsType">
                                                <option value="radio">Multiple choice</option>
                                                <option value="checkbox">Checkboxes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="row answers">
                        <div class="col-md-12 answers-item"
                             v-for="answer in answers">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-primary">
                                        <input disabled :type="inputsType">
                                    </div>
                                </div>
                                <input v-model="answer.text" type="text" class="form-control" placeholder="Enter an answer">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button @click="handleSave" class="btn btn-success">
                                        Save
                                    </button>
                                    <button @click="cancelEditMode" class="btn btn-secondary">Cancel</button>
                                </div>
                                <div class="btn-group">
                                    <button @click="addAnswer" class="btn btn-success">+</button>
                                    <button @click="removeAnswer" class="btn btn-danger">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!--list of questions and answers-->
                <edit-questions @editQuestion="setEditMode" class="edit-questions" ref="questions"
                                v-if="editModeText != 'Editing a question'"></edit-questions>
            </div>
        </div>

        <hr>


    </div>
</template>

<script>
import EditQuestions from './surevys/EditQuestions';

export default {
    components : {
        EditQuestions
    },
    data() {
        return {
            id: this.$route.params.id,
            type: 'public',
            title: '',
            stTitle: '',
            editFields: false,
            editModeText: 'Create a question',

            questionTitle: '',
            tempQuestion: {},

            inputsType: 'radio',
            answers: [{text: ''}],
            maxAnswers: 10
        }
    },
    methods: {
        setEditMode(question) {
            this.tempQuestion = question;
            this.answers = question.answers;
            this.questionTitle = question.title;
            this.inputsType = question.type;
            this.editModeText = 'Editing a question';
        },
        cancelEditMode() {
            this.clearInputs();
            this.editModeText = 'Create a question';
        },
        edit() {
            this.editFields = true;
        },
        cancelEdit() {
            this.editFields = false;
            this.title = this.stTitle;
        },
        handleSave() {
            if (this.editModeText == 'Create a question') {
                this.storeAll();
            } else {
                this.updateQuestion();
            }
        },
        // Update survey
        save() {
            this.axios.patch(`/survey/update/${this.id}`, {
                'title': this.title
            }).then((res) => {
                this.$toasted.show(res.data.message);
                this.stTitle = this.title;
                this.cancelEdit();
            }).catch((err) => {
                this.$toasted.show('Error');
            });
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
        clearInputs() {
            this.questionTitle = '';
            this.answers = [{text: ''}];
        },

        // Store question and answers
        storeAll() {
            this.axios.post(`/survey/questions/create`, {
                'survey_id': this.id,
                'question': {
                    title: this.questionTitle,
                    type: this.inputsType
                },
                'answers': this.answers
            }).then((res) => {
                this.$toasted.show(res.data.message);
                this.$refs.questions.addItem(res.data.question);
                this.clearInputs();
            }).catch((err) => {
                this.$toasted.show('Error');
            });
        },
        updateQuestion() {
            this.axios.post(`/survey/answers/update/${this.tempQuestion.id}`, {
                'answers': this.answers
            }).then((res) => {
                this.$toasted.show(res.data.message);
                this.cancelEditMode();
                this.clearInputs();
            }).catch((err) => {
                this.$toasted.show('Error');
            });

            this.axios.patch(`/survey/questions/update/${this.tempQuestion.id}`, {
                'type': this.inputsType,
                'title': this.questionTitle
            }).then((res) => {
                this.$toasted.show(res.data.message);
                this.cancelEditMode();
                this.clearInputs();
            }).catch((err) => {
                this.$toasted.show('Error');
            });
        }
    },
    beforeCreate() {
        // Get info about survey
        this.axios.get(`/survey/get/${this.$route.params.id}`)
            .then((res) => {
                this.title = this.stTitle = res.data.survey[0].title;
            })
            .catch((err) => {
                this.$toasted.show('Forbidden');
                this.$router.push({ name: 'surveys' });
            });
    },
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
.answers {
    margin: 10px 0;
}
.answers-item {
    margin: 5px 0;
}
.edit-questions {
    margin-bottom: 75px;
}
</style>