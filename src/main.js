import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './App.vue';
import home from './home.vue';
import api from './api';

if (window.location.protocol !== 'https:') {
  window.location.replace(`https:${window.location.href.substring(window.location.protocol.length)}`);
}

Vue.config.productionTip = false;

Vue.prototype.api = api;

Vue.use(VueRouter);

new Vue({
  router: new VueRouter({
    mode: 'hash',
    base: process.env.BASE_URL,
    routes: [
      {
        path: '/',
        name: 'Home',
        component: home,
      },
      {
        path: '/:music',
        name: 'Music',
        component: home,
      },
    ],
  }),
  render: (h) => h(App),
}).$mount('#app');
