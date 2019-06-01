<template>
    <div class="bg-primary col-md-12 auth-container">
        <transition name="slide" mode="out-in">
            <component :is="view" @changeView="changeView"></component>
        </transition>
    </div>
</template>

<script>
import Login from './Login';
import Register from './Register';

export default {
    components: {
        Login,
        Register
    },
    data() {
        return {
            view: 'login'
        }
    },
    methods: {
        changeView(view) {
            this.view = view;
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!Vue.auth.check()) {
            next();
        } else {
            Vue.router.push({ path: '/home' });
        }
    }
}
</script>

<style scoped>
.slide-leave-active,
.slide-enter-active {
    transition: .35s;
}
.slide-enter {
    transform: translate(-100%, 0);
}
.slide-leave-to {
    transform: translate(100%, 0);
}

.auth-container {
    overflow-x: hidden;
}
</style>