import Vue from 'vue';
import VueRouter from 'vue-router';
import VueScrollReveal from 'vue-scroll-reveal';
import app from './app.vue';
import home from './home.vue';
import api from './api';

if (window.location.hostname !== 'localhost' && window.location.protocol !== 'https:') {
  window.location.replace(`
    https:${window.location.href.substring(window.location.protocol.length)}
  `);
}

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js');
}

Vue.config.productionTip = false;

Vue.prototype.api = api;

Vue.use(VueScrollReveal, {
  duration: 500,
  scale: 0,
  distance: '10px',
});
Vue.use(VueRouter);

new Vue({
  router: new VueRouter({
    mode: 'history',
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
  render: (h) => h(app),
}).$mount('#app');
