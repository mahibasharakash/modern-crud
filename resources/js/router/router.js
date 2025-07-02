import {createRouter, createWebHistory} from "vue-router";

import layout from "../portal/layout/layout.vue";
import index from "../portal/pages/index.vue";

const routes = [
    {
        path: '', name: 'layout', component: layout,
        children: [
            { path: '' + '', name: 'index', component: index },
        ]
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to,from,savedPosition) {
        if(to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            };
        }else {
            return { top: 0, behavior: 'smooth' };
        }
    }
})

export default router;
