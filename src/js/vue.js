import Vue from 'vue';
import store from './store';
import http from './http';

// Tasks
import Example from '../vue/Example.vue';

// Polyfill the Standard Library functions
require('core-js');

window.Vue = Vue;

Vue.component('example', Example);

const app = new Vue({
	el: '#app',
	store
});