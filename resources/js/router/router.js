import { createRouter, createWebHistory } from "vue-router";
import cookieService from "../apiController/cookiesServices.js";

import layout from "../portal/layout/layout.vue";
import index from "../portal/pages/index.vue";

import authLayout from "../auth/layout/layout.vue";
import login from "../auth/pages/login.vue";
import registration from "../auth/pages/registration.vue";
import forgot from "../auth/pages/forgot.vue";
import reset from "../auth/pages/reset.vue";
import verification from "../auth/pages/verification.vue";

import profileLayout from "../profile/layout/layout.vue";
import details from "../profile/pages/details.vue";

const routes = [
    {
        path: '',
        name: 'layout',
        component: layout,
        children: [
            { path: '', name: 'index', component: index },
            {
                path: 'auth',
                name: 'authLayout',
                component: authLayout,
                children: [
                    { path: 'login', name: 'login', component: login },
                    { path: 'registration', name: 'registration', component: registration },
                    { path: 'forgot', name: 'forgot', component: forgot },
                    { path: 'reset', name: 'reset', component: reset },
                    { path: 'verification', name: 'verification', component: verification },
                ],
            },
            {
                path: 'profile',
                name: 'profileLayout',
                component: profileLayout,
                children: [
                    { path: 'details', name: 'details', component: details },
                ],
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return { el: to.hash, behavior: 'smooth' };
        } else {
            return { top: 0, behavior: 'smooth' };
        }
    },
});

router.beforeEach((to, from, next) => {
    const authToken = cookieService.get('auth_token');

    const authRequired = to.matched.some(record => record.path.startsWith('/profile'));
    const isAuthRoute = to.matched.some(record => record.path.startsWith('/auth'));

    if (isAuthRoute && authToken) {
        next({ name: 'details' });
    } else if (authRequired && !authToken) {
        next({ name: 'login' });
    } else {
        next();
    }
});

export default router;
