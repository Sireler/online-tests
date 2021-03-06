
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './components/App';

import {router} from './routes.js';

//vue-toasted
import Toasted from 'vue-toasted';

Vue.use(Toasted, {
    fullWidth: true,
    duration: 3000,
    position: 'bottom-left',
    theme: 'bubble'
});
//--

//v-slim-dialog   modal
import 'v-slim-dialog/dist/v-slim-dialog.css';
import SlimDialog from 'v-slim-dialog';

Vue.use(SlimDialog);
//--

/**
 * Vue-auth lib for authentication with jwt token
 */
let axios = window.axios;
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);
Vue.axios.defaults.baseURL = window.location.origin + '/api';
Vue.router = router;

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js')
});

// Navigation guard
router.beforeEach((to, from, next) => {
    if (Vue.auth.check()) {
        next();
    } else if (to.path === '/auth' || to.path === '/') {
        next();
    } else {
        router.push({path: '/auth'});
    }
});

// Handle 401 error
axios.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.request.responseURL.indexOf('/auth/login') > 0) {

    } else if (error.response.status === 401) {
        router.push({path: '/'});
    }

    return Promise.reject(error);
});

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
