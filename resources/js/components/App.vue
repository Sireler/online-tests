<template>
    <div>
        <div v-if="$auth.ready()" class="row app-container">
            <app-nav v-if="$route.path !== '/' && $auth.check()"></app-nav>
            <router-view class="col-md-8"></router-view>
        </div>
        <div v-if="!$auth.ready()" class="container-fluid">
            <div class="col-6 m-auto">
                <div class="lds-ripple"><div></div><div></div></div>
            </div>
        </div>
        <footer>Footer &copy; 2018</footer>
    </div>
</template>

<script>
import AppNav from './Nav';

export default {
    components: {
        AppNav
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

.lds-ripple {
    display: inline-block;
    position: relative;
    width: 256px;
    height: 256px;
    left: 50%;
    margin-left: -128px;
    margin-top: 35%;

}
.lds-ripple div {
    position: absolute;
    border: 4px solid #3490DC;
    opacity: 1;
    border-radius: 50%;
    animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
    animation-delay: -0.5s;
}

footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #5f2a62;
    text-align: center;
    color: #a976c3;
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
