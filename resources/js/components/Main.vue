<template>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Surveys</h1>
            <p class="lead">Register and create survey or test!</p>
            <hr class="my-4">
            <div class="cards">
                <div class="row cards-row">
                    <div class="col-md-6">
                        <button @click="toAuth" class="btn btn-block btn-outline-primary">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            toAuth() {
                this.$router.push({ path: '/auth'});
            }
        }
    }
</script>

<style scoped>
.jumbotron {
    background-color: #fff;
}
</style>
<style>

</style>