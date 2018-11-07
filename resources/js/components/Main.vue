<template>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Surveys</h1>
            <p class="lead">Зарегистрируйтесь и создайте свой первый опрос!</p>
            <hr class="my-4">
            <div class="cards">
                <div class="row cards-row">
                    <div class="col-md-12">
                        <button @click="toAuth" class="btn btn-block btn-outline-primary">Вход</button>
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