/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import GiftIndex from './components/gift/GiftIndex.vue';

const routes = [
    {
        path: '/',
        components: {
            giftIndex: GiftIndex
        }
    },
    // {path: '/admin/companies/create', component: CompaniesCreate, name: 'createCompany'},
    // {path: '/admin/companies/edit/:id', component: CompaniesEdit, name: 'editCompany'},
];

const router = new VueRouter({ routes });

const app = new Vue({ router }).$mount('#app');
