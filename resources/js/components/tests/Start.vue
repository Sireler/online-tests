<template>
    <div class="container">
        <div class="alert alert-info">
            <h4>Test name: {{ test.title }}</h4>
            <hr>
            <p>Question {{ current + 1 }} of {{ questionsCount }}</p>
        </div>
        <div class="card card-info">
            <div class="card-header">
                {{ test.questions[current].title }}
            </div>
            <div class="card-body">
                <div class="form-group" v-for="(answer, i) in test.questions[current].answers">
                    <input :value="i"
                           v-model="selectedAnswer"
                           type="radio"
                           :id="'a' + i">
                    <label :for="'a' + i">
                        {{ letters[i] }}) {{ answer }}
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
            test: {
                title: "Test 1",
                questions: {
                    0: {
                        answers: {
                            0: "answer 11",
                            1: "answer 12",
                            2: "answer 13",
                            3: "answer 14"
                        },
                        correctIndex: 2,
                        title: "Quest 1"
                    },
                    1: {
                        answers: {
                            0: "answer 21",
                            1: "answer 22",
                            2: "answer 23",
                            3: "answer 24"
                        },
                        correctIndex: 1,
                        title: "Quest 2"
                    },
                },
            },
            current: 0,
            selectedAnswer: 0,
            letters: ['A', 'B', 'C', 'D']
        }
    },
    methods: {
        nextQuestion(e) {
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
            console.log('1');
        }
    },
    computed: {
        questionsCount() {
            return Object.keys(this.test.questions).length;
        }
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