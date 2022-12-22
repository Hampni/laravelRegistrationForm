/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.Vue = require('vue').default;
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueSession from "vue-session";

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Echo from 'laravel-echo';


Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


Vue.component('pagination', require('laravel-vue-pagination'))
Vue.use(VueSession);
Vue.component('form-page', require('./components/v-form.vue').default)
Vue.component('members-page', require('./components/v-members.vue').default)
Vue.component('admin-page', require('./components/v-admin-panel.vue').default)
Vue.component('update-page', require('./components/v-update.vue').default)
Vue.component('add-page', require('./components/v-add.vue').default)



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    created() {
        window.Echo.channel('notification')
                   .listen('MessageNotification', (e) => {
                       console.log('Well, this showed up without a refresh!');
                   })
    }
});




