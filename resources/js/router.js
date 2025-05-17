import { createRouter, createWebHistory } from "vue-router";

import Dashboard from './components/Dashboard.vue'
import Service from './components/Service.vue'


const routes = [
    { path: '/', component: Dashboard, name: 'Dashboard' },
    { path: '/service', component: Service, name: 'Service' },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
