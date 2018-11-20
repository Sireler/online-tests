<template>
    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-thead">
                        <th>TITLE</th>
                        <th>CREATED</th>
                        <th>RESPONSES</th>
                        <th>MANAGE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="survey in surveysTable">
                        <td>{{ survey.title }}</td>
                        <td>{{ survey.created_at }}</td>
                        <td>0</td>
                        <td>
                            <span @click="deleteSurvey(survey.id)"
                                >Delete</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="btn-group" role="group">
                <router-link class="btn btn-secondary" to="tests/create">Create</router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            surveysTable: {}
        }
    },
    methods: {
        getUserSurveys() {
            this.axios.get('/survey/index')
                .then((res) => {
                    this.surveysTable = res.data.surveys;
                });
        },
        deleteSurvey(id) {
            //TODO::DELETE SURVEY
        }
    },
    mounted() {
        this.getUserSurveys();
    }
}
</script>

<style scoped>
.table-thead {
    background-color: #5f2a62;
    color: #fff;
}
.table tbody tr {
    background-color: #fff;
}
    
span {
    cursor: pointer;
    color: #5f2a62;
}
</style>