<template>
    <div class="container">
        <h2>Создание теста</h2>
        <div v-if="state === 'ask'">
            <div class="form-group">
                <label for="questions">Number of questions</label>
                <input v-model="numQuestions" id="questions" type="number" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-secondary"
                        @click="startCreate">
                    Next
                </button>
            </div>
        </div>
        <div v-if="state === 'creating'">
            <h5>Question {{ currQuestion + 1 }}</h5>
            <div class="form-group questions-start">
                <label for="test-title">Test title</label>
                <input v-model="testTitle" id="test-title" type="text" class="form-control">
            </div>
            <button class="btn btn-secondary"
                    @click="startQuestions">
                Next
            </button>
        </div>
        <div v-if="state === 'questions'">
            <div class="alert alert-info">
                <h5>Test: {{ testTitle }}</h5>
                <hr>
                Question {{ currQuestion + 1 }} / {{ numQuestions }}
            </div>
            <div class="form-group">
                <label>Question</label>
                <input v-model="questions.title" class="form-control" type="text">
            </div>
            <hr>
            <div class="row">
                <div class="form-group col-md-10">
                    <label>(A)</label>
                    <input v-model="answers[0]" type="text" class="form-control">
                </div>
                <label class="col-md-2">
                    <input v-model="correct" value="0" type="radio" class="form-check" checked>
                    <span class="oi oi-check"></span>
                </label>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <label>(B)</label>
                    <input v-model="answers[1]" type="text" class="form-control">
                </div>
                <label class="col-md-2">
                    <input v-model="correct" value="1" type="radio" class="form-check">
                    <span class="oi oi-check"></span>
                </label>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <label>(C)</label>
                    <input v-model="answers[2]" type="text" class="form-control">
                </div>
                <label class="col-md-2">
                    <input v-model="correct" value="2" type="radio" class="form-check">
                    <span class="oi oi-check"></span>
                </label>
            </div>
            <div class="row">
                <div class="form-group col-md-10">
                    <label>(D)</label>
                    <input v-model="answers[3]" type="text" class="form-control">
                </div>
                <label class="col-md-2">
                    <input v-model="correct" value="3" type="radio" class="form-check">
                    <span class="oi oi-check"></span>
                </label>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-secondary"
                            @click="nextQuestion">
                        Next
                    </button>
                </div>
            </div>
        </div>
        <div v-if="state === 'result'">
            <result-table
                    :testTitle="testTitle"
                    :questions="questions"
            ></result-table>
        </div>
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
            numQuestions: 2,
            currQuestion: 0,
            testTitle: '',
            state: 'ask',
            questions: [],
            question: {},
            answers: [],
            correct: 0	,
        }
    },
    methods: {
        startCreate() {
            this.state = 'creating';
        },
        startQuestions() {
            this.state = 'questions';
        },
        nextQuestion() {

            this.questions.push({
                title: this.questions.title,
                answers: {
                    0: this.answers[0],
                    1: this.answers[1],
                    2: this.answers[2],
                    3: this.answers[3]
                },
                correctIndex: this.correct
            });

            // next screen if last question
            if (this.lastQuestion) {
                this.state = 'result';
                return;
            }

            this.currQuestion++;
            this.questions.title = '';
            this.answers = [];
        }
    },
    computed: {
        lastQuestion() {
            return this.currQuestion + 1 === this.numQuestions;
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