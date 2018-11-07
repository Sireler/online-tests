<template>
    <div class="row app-container">
        <app-nav v-if="$route.path !== '/'"></app-nav>
        <router-view class="col-md-8"></router-view>
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
</style>
