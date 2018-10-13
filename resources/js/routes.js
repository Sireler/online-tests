import Vue from 'vue';
import VueRouter from 'vue-router';

import AppHome from './components/home/Home';

// Auth
import Auth from './components/auth/Auth';

// 404 error component
import NotFound from './components/NotFound';

Vue.use(VueRouter);

const routes = [
    { path: '/home', component: AppHome },

    // Auth
    { path: '/auth', component: Auth },

    // Not found
    { path: '*', component: NotFound }
];

export const router = new VueRouter({
    mode: 'history',
    routes
});
