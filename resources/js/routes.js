import Vue from 'vue';
import VueRouter from 'vue-router';

import AppMain from './components/Main';
import AppHome from './components/home/Home';

// Auth
import Auth from './components/auth/Auth';

// 404 error component
import NotFound from './components/NotFound';

// Tests
import Tests from './components/tests/Tests';
import CreateTest from './components/tests/Create';
import StartTest from './components/tests/Start';
import EditTest from './components/tests/Edit';
import EditSurveyQuestions from './components/tests/surevys/EditQuestions';

Vue.use(VueRouter);

const routes = [

    { path: '/', component: AppMain },
    { path: '/home', name: 'home', component: AppHome },

    // Auth
    { path: '/auth', component: Auth },

    // Not found
    { path: '*', component: NotFound },

    // Tests
    { path: '/tests', component: Tests },
    { path: '/tests/create', component: CreateTest },
    { path: '/tests/start/:id', component: StartTest, props: true },
    { path: '/tests/edit/:id', component: EditTest, props: true },
    { path: '/tests/edit/:id/questions', component: EditSurveyQuestions, props: true },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export {router};