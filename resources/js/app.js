import './bootstrap';
import { createApp } from 'vue';
import Index from './Index.vue';
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import App from './components/App.vue';
import Login from './components/Login.vue';
import { createRouter, createWebHistory } from 'vue-router';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import '@mdi/font/css/materialdesignicons.css';

const routes = [
    { path: '/', component: App },
    { path: '/login', component: Login },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(Index);

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
});

app.use(vuetify);

app.use(router);

app.mount('#app');
