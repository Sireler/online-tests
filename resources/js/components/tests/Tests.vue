<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div v-if="surveysTable !== null && surveysTable.length > 0">
                    <SurveysTable :surveys="surveysTable"></SurveysTable>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="alert alert-info"
                     v-if="surveysTable == null || surveysTable.length <= 0">
                    You have no surveys
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="btn-group" role="group">
                    <router-link class="btn btn-secondary" :to="{ name: 'surveys.create' }">Create</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SurveysTable from '../surveys/SurveysTable';

export default {
    components: {
        SurveysTable
    },
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
    },
    mounted() {
        this.getUserSurveys();
    }
}
</script>

<style scoped>

</style>