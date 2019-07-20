<template>
    <table class="table bg-white rounded">
        <thead>
        <tr class="table-thead text-uppercase">
            <th>Title</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(survey, index) in surveys">
            <td>{{ survey.title }}</td>
            <td>{{ survey.created_at }}</td>
            <td>
                                <span class="oi oi-circle-x" title="Delete survey"
                                      @click="deleteSurvey(survey.id, index)"></span>
                <span class="oi oi-wrench" title="Edit survey"
                      @click="editSurvey(survey.id)"></span>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "SurveysTable",
    props: ['surveys'],
    methods: {
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
            this.$router.push({ name: 'surveys.edit', params: { id: id } });
        }
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

span {
    cursor: pointer;
    color: #5f2a62;
    user-select: none;
    margin-left: 10px;
}
</style>