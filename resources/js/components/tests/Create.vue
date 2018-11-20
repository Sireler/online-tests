<template>
    <div class="container">
        <h2>New survey</h2>
        <div>
            <div class="form-group questions-start">
                <label for="test-title">Name your survey</label>
                <input v-model="surveyName" id="test-title" type="text" class="form-control">
            </div>
            <button class="btn btn-secondary"
                    @click="createSurvey">
                Create survey
            </button>
        </div>
        <!--<div v-if="state === 'questions'">-->
            <!--<div class="alert alert-info">-->
                <!--<h5>Test: {{ testTitle }}</h5>-->
                <!--<hr>-->
                <!--Question {{ currQuestion + 1 }} / {{ numQuestions }}-->
            <!--</div>-->
            <!--<div class="form-group">-->
                <!--<label>Question</label>-->
                <!--<input v-model="questions.title" class="form-control" type="text">-->
            <!--</div>-->
            <!--<hr>-->
            <!--<div class="row">-->
                <!--<div class="form-group col-md-10">-->
                    <!--<label>(A)</label>-->
                    <!--<input v-model="answers[0]" type="text" class="form-control">-->
                <!--</div>-->
                <!--<label class="col-md-2">-->
                    <!--<input v-model="correct" value="0" type="radio" class="form-check" checked>-->
                    <!--<span class="oi oi-check"></span>-->
                <!--</label>-->
            <!--</div>-->
            <!--<div class="row">-->
                <!--<div class="form-group col-md-10">-->
                    <!--<label>(B)</label>-->
                    <!--<input v-model="answers[1]" type="text" class="form-control">-->
                <!--</div>-->
                <!--<label class="col-md-2">-->
                    <!--<input v-model="correct" value="1" type="radio" class="form-check">-->
                    <!--<span class="oi oi-check"></span>-->
                <!--</label>-->
            <!--</div>-->
            <!--<div class="row">-->
                <!--<div class="form-group col-md-10">-->
                    <!--<label>(C)</label>-->
                    <!--<input v-model="answers[2]" type="text" class="form-control">-->
                <!--</div>-->
                <!--<label class="col-md-2">-->
                    <!--<input v-model="correct" value="2" type="radio" class="form-check">-->
                    <!--<span class="oi oi-check"></span>-->
                <!--</label>-->
            <!--</div>-->
            <!--<div class="row">-->
                <!--<div class="form-group col-md-10">-->
                    <!--<label>(D)</label>-->
                    <!--<input v-model="answers[3]" type="text" class="form-control">-->
                <!--</div>-->
                <!--<label class="col-md-2">-->
                    <!--<input v-model="correct" value="3" type="radio" class="form-check">-->
                    <!--<span class="oi oi-check"></span>-->
                <!--</label>-->
            <!--</div>-->
            <!--<div class="row">-->
                <!--<div class="col-md-12">-->
                    <!--<button class="btn btn-secondary"-->
                            <!--@click="nextQuestion">-->
                        <!--Next-->
                    <!--</button>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div v-if="state === 'result'">-->
            <!--<result-table-->
                    <!--:testTitle="testTitle"-->
                    <!--:questions="questions"-->
            <!--&gt;</result-table>-->
        <!--</div>-->
    </div>
</template>

<script>
import ResultTable from './ResultTable';

export default {
    components: {
        ResultTable
    },
    data() {
        return {
            surveyName: ''
        }
    },
    methods: {
        // startCreate() {
        //     this.state = 'creating';
        // },
        // startQuestions() {
        //     this.state = 'questions';
        // },
        // nextQuestion() {
        //
        //     this.questions.push({
        //         title: this.questions.title,
        //         answers: {
        //             0: this.answers[0],
        //             1: this.answers[1],
        //             2: this.answers[2],
        //             3: this.answers[3]
        //         },
        //         correctIndex: this.correct
        //     });
        //
        //     this.currQuestion++;
        //     this.questions.title = '';
        //     this.answers = [];
        // },
        createSurvey() {
            if (this.checkSurveyName()) {
                this.axios.post('/survey/create', {
                    'title': this.surveyName
                }).then((res) => {
                    this.$toasted.show(res.data.message);
                }).catch((err) => {
                    console.log(err);
                });
            }
        },
        checkSurveyName() {
            return this.surveyName.length > 0;
        }

    }
}
</script>

<style scoped>
.questions-start {
    margin-top: 20px;
}

.container {
    min-height: 10px;
}

.oi-check {
    color: green;
    margin-top: 20px;
}
</style>