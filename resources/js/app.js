/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router'
Vue.use(VueRouter)


import { routes } from './router.js';

const router = new VueRouter({
    routes,
    mode: 'history'
  })


const app = new Vue({
    el: '#app',
    router
});
