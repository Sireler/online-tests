<template>
    <div class="container login-container">
        <transition name="slide" mode="out-in">
            <component :is="view"
                       @changeView="changeView"></component>
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
    }
}
</script>

<style scoped>
.slide-leave-active,
.slide-enter-active {
    transition: .5s;
}
.slide-enter {
    transform: translate(-100%, 0);
}
.slide-leave-to {
    transform: translate(100%, 0);
}

.login-container {
    overflow-x: hidden;
}
</style>