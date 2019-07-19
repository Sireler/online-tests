<template>
    <div>
        <app-nav v-if="$route.path !== '/' && $auth.check()"></app-nav>
        <div v-if="$auth.ready()" class="row m-0 bg-primary">
            <router-view class="mt-3"></router-view>
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

footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    text-align: center;
}

.toasted.bubble {
    background-color: #fff;
    color: #0747A6;
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
