import Vue from 'vue';
import VueRouter from 'vue-router';
import VueScrollReveal from 'vue-scroll-reveal';
import app from './App.vue';
import home from './home.vue';

if ('serviceWorker' in navigator) navigator.serviceWorker.register('/sw.js');

Vue.config.productionTip = false;

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
