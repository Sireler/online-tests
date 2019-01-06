<template>
    <div class="container">
        <div class="row">
            <table v-if="surveysTable.length > 0" class="table table-bordered">
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
                            <span class="oi oi-circle-x" title="Delete survey"
                                  @click="deleteSurvey(survey.id, index)"></span>
                            <span class="oi oi-wrench" title="Edit survey"
                                  @click="editSurvey(survey.id)"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="alert alert-info"
             v-if="surveysTable.length <= 0">
            You have no surveys
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
                    this.$toasted.show('Request error');
                    window.location.reload();
                });
        },
        deleteSurvey(id, index) {
            this.$dialogs.confirm('Are you sure you want to delete a survey?', {
                title: 'Delete survey', okLabel: 'Delete'
            }).then(res => {
                if (res.ok) {
                    this.axios.delete(`/survey/delete/${id}`)
                        .then((res) => {
                            this.surveysTable.splice(index, 1);
                            this.$toasted.show(res.data.message);
                        })
                        .catch((err) => {
                            this.$toasted.show('Forbidden');
                        });
                }
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
.oi {
    font-size: 1.15em;
}
.oi-circle-x {
    color: #ff0000;
}
.oi-wrench {
    color: #29ab0f;
}

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