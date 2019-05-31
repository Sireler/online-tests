<template>
<!--    <div class="main col-md-12">-->
<!--        <div class="container">-->
<!--            <div class="jumbotron">-->
<!--                <h1 class="display-4">Surveys</h1>-->
<!--                <p class="lead">Register and create survey or test!</p>-->
<!--                <hr class="my-4">-->
<!--                <div class="cards">-->
<!--                    <div class="row cards-row">-->
<!--                        <div class="col-md-6">-->
<!--                            <button @click="toAuth" class="btn btn-block btn-outline-primary">Continue</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="main col-md-12">
        <div class="row">
            <div class="col-md-12 my-2">
                <a class="text-white app-name nav-link" href="/">Surveys</a>
            </div>
        </div>
        <div class="col-md-12 about bg-white jumbotron">
            <div class="container">
                <h1>Create surveys and get answers</h1>
                <p class="lead">You can create and manage public and private surveys</p>
                <div>
                    <button @click="toAuth" class="btn btn-outline-primary text-uppercase">Sign up</button>
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
.main {
    width: 100%;
    background-color: #0747A6;
}

.about {
    min-height: 200px;
}
.app-name {
    font-size: 1.5em;
}
</style>
<style>

</style>