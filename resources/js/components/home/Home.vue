<template>
    <div class="container">
        <div class="jumbotron bg-primary text-white">
            <h1 class="display-4">Surveys</h1>
            <p class="lead">List of your surveys</p>
            <hr class="my-4">
            <div class="cards">
                <div v-if="surveysTable !== null && surveysTable.length > 0" class="row cards-row">
                    <div class="col-md-6">
                        <div class="card" v-for="survey in surveysTable">
                            <div class="card-body">
                                <h5 class="card-title">Survey: {{ survey.title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted"></h6>
                                <router-link class="card-link" :to="`/tests/start/${survey.id}`">Start</router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info"
                     v-if="surveysTable == null || surveysTable.length <= 0">
                    You don't have surveys ready
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            surveysTable: []
        }
    },
    methods: {
        loadSurveys() {
            this.$parent.showLoading();
            this.axios.get('/survey/home')
                .then((res) => {
                    this.surveysTable = res.data.surveys;
                    this.$parent.hideLoading();
                })
                .catch((err) => {
                    this.$router.push({ path: `/` });
                    this.$toasted.show('Request error');
                    window.location.reload();
                });
        }
    },
    mounted() {
        this.loadSurveys();
    }
}
</script>

<style scoped>
.cards .card {
    float: left;
    width: 95%;
}
.cards .cards-row {
    margin-bottom: 20px;
    color: #000;
}
</style>