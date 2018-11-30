<template>
    <div class="container">
        <div class="row">
            <table v-if="surveysTable !== null" class="table table-bordered">
                <thead>
                    <tr class="table-thead">
                        <th>TITLE</th>
                        <th>CREATED</th>
                        <th>RESPONSES</th>
                        <th>MANAGE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(survey, index) in surveysTable">
                        <td>{{ survey.title }}</td>
                        <td>{{ survey.created_at }}</td>
                        <td>0</td>
                        <td>
                            <span @click="deleteSurvey(survey.id, index)"
                                >Delete</span>
                            <span @click="editSurvey(survey.id)"
                            >Edit</span>
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
            surveysTable: null
        }
    },
    methods: {
        getUserSurveys() {
            this.$parent.showLoading();
            this.axios.get('/survey/index')
                .then((res) => {
                    this.surveysTable = res.data.surveys;
                    this.$parent.hideLoading();
                })
                .catch((err) => {
                    this.$router.push({ path: `/` });
                });
        },
        deleteSurvey(id, index) {
            this.axios.delete(`/survey/delete/${id}`)
                .then((res) => {
                    this.surveysTable.splice(index, 1);
                    this.$toasted.show(res.data.message);
                })
                .catch((err) => {
                    this.$toasted.show('Forbidden');
                });
        },
        editSurvey(id) {
            this.$router.push({ path: `/tests/edit/${id}` });
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
    user-select: none;
    margin-left: 10px;
}
</style>