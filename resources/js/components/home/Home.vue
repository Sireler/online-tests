<template>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Surveys</h1>
            <p class="lead">List of surveys</p>
            <hr class="my-4">
            <div class="cards">
                <div class="row cards-row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Name</h5>
                                <h6 class="card-subtitle mb-2 text-muted">count</h6>
                                <router-link class="card-link" to="/tests/start/1">Start</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Name</h5>
                                <h6 class="card-subtitle mb-2 text-muted">count</h6>
                                <a href="#" class="card-link">Start</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.cards .card {
    float: left;
    width: 95%;
}

.cards .cards-row {
    margin-bottom: 20px;
}
</style>