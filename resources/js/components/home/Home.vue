<template>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Главная страница</h1>
            <p class="lead">Lead</p>
            <hr class="my-4">
            <div class="cards">
                <div class="row cards-row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Название карточки</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Количество вопросов:</h6>
                                <a href="#" class="card-link">Пройти тест</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Название карточки</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Количество вопросов:</h6>
                                <a href="#" class="card-link">Пройти тест</a>
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