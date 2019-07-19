<template>
    <div class="container text-white">
        <div class="row">
            <div class="col-md-8 offset-md-2">
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
            </div>
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
            surveyName: ''
        }
    },
    methods: {
        createSurvey() {
            if (this.checkSurveyName()) {
                this.axios.post('/survey/create', {
                    'title': this.surveyName
                }).then((res) => {
                    this.$toasted.show(res.data.message);
                    this.$router.push({ name: 'surveys' });
                }).catch((err) => {
                    // err
                });
            } else {
                this.$toasted.show('Survey name must be of minimum 6 characters length');
            }
        },
        checkSurveyName() {
            return this.surveyName.length > 5;
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