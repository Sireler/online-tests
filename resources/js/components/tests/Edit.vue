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

        <div class="jumbotron">
            <h3>Create question</h3>
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
                                    <select @change="generateByType" class="form-control" id="type">
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
                            <div class="input-group-text">
                                <input disabled :type="inputsType">
                            </div>
                        </div>
                        <input v-model="answer.text" type="text" class="form-control" placeholder="Enter an answer">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <button @click="storeAll" class="btn btn-success right">Save</button>
                    <button @click="addAnswer" class="btn btn-secondary">+</button>
                    <button @click="removeAnswer" class="btn btn-danger">-</button>
                </div>
            </div>
        </div>

        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body text-primary">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
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
            maxAnswers: 10
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