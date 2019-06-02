<template>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <router-link class="navbar-brand" to="/home">Surveys</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link class="nav-link" to="/tests" activeClass="active">My surveys</router-link>
                </li>
            </ul>
            <button class="btn btn-outline-primary" @click="logout">
              Logout
            </button>
        </div>
    </nav>

</template>

<script>
export default {
    methods: {
        logout() {
            this.$auth.logout({
                makeRequest: true,
                success: (res) => {
                    this.$toasted.show('You have been logged out');
                },
                error: function (res) {
                    //console.log(res)
                },
                redirect: '/',
            });
        }
    }
}
</script>

<style scoped>

</style>