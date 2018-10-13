<template>
    <div>
        <h2>Test title: {{ testTitle }}</h2>
        <table class="table table-striped">
            <tr>
                <td class="text-center">Question title</td>
                <td class="text-center">Answer</td>
                <td class="text-center">Correct</td>
            </tr>
            <template v-for="question in questions">
                <tr>
                    <td class="table-title" rowspan="5">{{ question.title }}</td>
                </tr>
                <tr v-for="(answer, i) in question.answers">
                    <td class="table-answer">{{ answer }}</td>
                    <td class="text-center">{{ question.correctIndex == i ? '+' : '-'}}</td>
                </tr>
            </template>
        </table>
        <button class="btn btn-secondary"
                @click="createTest">
            Create
        </button>
    </div>
</template>

<script>
export default {
    props: ['testTitle', 'questions'],
    methods: {
        createTest() {
            console.log(this.questions);
        },
    },
}
</script>

<style scoped>
table {
    background-color: #fff;
}
table .table-title {
    text-align: center;
    vertical-align: middle;
}
table .table-answer {
    border-left: 1px solid #DEE2E6;
}
</style>