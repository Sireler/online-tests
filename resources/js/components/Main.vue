<template>
    <div class="main col-md-12">
        <navbar></navbar>
        <div class="container">
            <div class="row">
                <div class="col-md-12 about bg-white jumbotron">
                    <div class="container">
                        <h1>Create surveys and get answers</h1>
                        <p class="lead">You can create and manage surveys</p>
                        <div v-if="!$auth.check()">
                            <button @click="toAuth" class="btn btn-outline-primary text-uppercase">Sign up</button>
                        </div>
                        <div v-else>
                            <button @click="toAuth" class="btn btn-outline-primary text-uppercase">Start</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Navbar from './TopNavbar';

    export default {
        components: {
            Navbar
        },
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