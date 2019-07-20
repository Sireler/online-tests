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
import SurveyResposnes from './components/surveys/responses/SurveyResponses';

Vue.use(VueRouter);

const routes = [

    { path: '/', component: AppMain },
    { path: '/home', name: 'home', component: AppHome },

    // Auth
    { path: '/auth', component: Auth },

    // Surveys
    {
        path: '/surveys',
        name: 'surveys',
        component: Tests
    },
    {
        path: '/surveys/create',
        name: 'surveys.create', component: CreateTest
    },
    {
        path: '/surveys/start/:id',
        name: 'surveys.start',
        component: StartTest,
        props: true
    },
    {
        path: '/surveys/edit/:id',
        name: 'surveys.edit',
        component: EditTest,
        props: true
    },
    {
        path: '/surveys/edit/:id/questions',
        name: 'surveys.questions.edit',
        component: EditSurveyQuestions,
        props: true
    },
    {
        path: '/surveys/:id/responses',
        name: 'surveys.responses',
        component: SurveyResposnes
    },

    // Not found
    { path: '*', component: NotFound },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export {router};