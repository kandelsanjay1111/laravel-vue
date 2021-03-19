/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';

import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify);

import Swal from 'sweetalert2';
window.Swal = require('sweetalert2')

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

console.log('user', window.user);
import dashboard from './components/Dashboard.vue'
import profile from './components/Profile.vue'
import user from './components/Users.vue'



Vue.use(VueProgressBar,{
	color:'rgb(143,255,199)',
	failedColor:'red',
	height:'3px'
});

let routes = [
  { path: '/dashboard', component: dashboard },
  { path: '/profile', component: profile },
  { path: '/users', component: user }
]

const router = new VueRouter({
	mode:'history',
	routes 
})


Vue.filter('textup',function(value){
	return value.charAt(0).toUpperCase() + value.slice(1);
});
Vue.filter('mydate',function(created){
	return moment(created).format('MMMM Do YYYY');
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	el:'#app',
	vuetify: new Vuetify(),
    router
});
