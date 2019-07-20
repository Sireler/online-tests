<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Responses</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SurveyResponses",
    computed: {
        id() {
            return this.$route.params.id;
        }
    },
}
</script>

<style scoped>

</style>