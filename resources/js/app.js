require('./bootstrap');

import router from './router'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import common from './common'
import Vue from 'vue';
import store from './store'


// if any error Vue.component is not function just add below code ".default" //
window.Vue = require('vue').default;

Vue.use(ViewUI);
Vue.mixin(common)

Vue.component('mainapp', require('./components/mainapp.vue').default)
const app = new Vue({
    el: '#app', 
    router, 
    store
})
