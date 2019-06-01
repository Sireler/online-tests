<template>
    <div>
        <div v-if="$auth.ready()" class="row app-container bg-primary">
            <app-nav v-if="$route.path !== '/' && $auth.check()"></app-nav>
            <router-view class="col-md-12"></router-view>
        </div>
        <app-loader ref="appload" v-if="loading"></app-loader>
        <footer class="bg-primary"><router-link class=" text-white" to="/">Surveys &copy; 2018</router-link></footer>
    </div>
</template>

<script>
import AppNav from './Nav';
import AppLoader from './Loader';

export default {
    components: {
        AppNav,
        AppLoader
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        showLoading() {
            this.loading = true;
        },
        hideLoading() {
            this.loading = false;
        }
    }
}
</script>

<style>
* {
    margin: 0;
    padding: 0;
}

#app {
    background-color: #eee;
    min-height: 100vh;
}

.app-container {
    min-height: 100vh;
    margin: 0;
}

.container {
    margin-top: 10px;
}

footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    text-align: center;
}

.toasted.bubble {
    background-color: #5f2a62;
}

.api-loading {
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    position: absolute;
    z-index: 999;
}

/*v-slim-dialog style*/
.v-dialog-container {
    background-color: #A976C3;
    color: #fff;
}
.v-dialog-btn.success {
    background-color: #F04747;
    color: #fff;
    border-radius: 5px;
}
.v-dialog-btn.success:hover {
    background-color: #C73B3B;
}
a.v-dialog-btn-danger,
.v-dialog-btn-close,
.v-dialog-title {
    color: #fff !important;
}
a.v-dialog-btn-danger:hover {
    text-decoration: underline !important;
}
/*end v-slim-dialog style*/

@keyframes lds-ripple {
    0% {
        top: 45%;
        left: 45%;
        width: 0;
        height: 0;
        opacity: 1;
    }
    100% {
        top: -1px;
        left: -1px;
        width: 95%;
        height: 95%;
        opacity: 0;
    }
}
</style>
