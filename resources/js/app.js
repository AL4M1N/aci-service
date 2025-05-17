import './bootstrap';

import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import common from './components/common/mixin';

import { createVuetify } from 'vuetify';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
const Vuetify = createVuetify({
    components,
    directives,
})

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';

createApp(App).use(router).use(Vuetify).mixin(common).component('VueDatePicker', VueDatePicker).mount('#app');
