require("./bootstrap")
import Vue from 'vue';

window.Vue = Vue;
import store from './Store';
import router from './Router'
import 'vuetify/dist/vuetify.min.css';
import vuetify from "./plugins/vuetify";

window.breakpoints = vuetify.framework.breakpoint;
const files = require.context('./Pages', true, /\.vue$/i);

files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

new Vue({
  router,
  store,
  vuetify,
}).$mount('#mwc_multiwoocom_dashboard');

