<template>
    <nav class="col-md-2 text-center text-md-left app-nav">
        <div class="nav flex-column nav-pills" id="v-pills-tab">
            <router-link v-if="!$auth.check()" class="nav-link" to="/" exact-active-class="active">Main</router-link>
            <router-link class="nav-link" to="/home" activeClass="active">Home</router-link>
            <router-link class="nav-link" to="/tests" activeClass="active">Tests</router-link>
            <router-link v-if="!$auth.check()" class="nav-link" to="/auth" activeClass="active">Login</router-link>
            <a href="" @click.prevent="logout" v-if="$auth.check()" class="nav-link" >Logout</a>
        </div>
    </nav>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$auth.logout({
                makeRequest: true,
                success: function (res) {
                    //console.log(res)
                },
                error: function (res) {
                    //console.log(res)
                },
                redirect: '/',
                // etc...
            });
        }
    }
}
</script>

<style scoped>
.app-nav {
    padding-top: 10px;
    min-height: inherit;
    background: #fff;
    box-shadow: 5px 0 5px -5px #cccccc;
}

@media screen and (max-width: 767px) {
    .app-nav {
        min-height: 0;
        box-shadow: none;
    }
}
</style>