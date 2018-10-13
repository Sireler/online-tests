import Vue from 'vue';
import VueRouter from 'vue-router';

import AppHome from './components/home/Home';

// Auth
import Auth from './components/auth/Auth';

Vue.use(VueRouter);

const routes = [
    { path: '/home', component: AppHome },

    // Auth
    { path: '/auth', component: Auth }
];

export const router = new VueRouter({
    mode: 'history',
    routes
});
