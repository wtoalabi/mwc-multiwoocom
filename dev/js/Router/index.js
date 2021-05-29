import Vue from 'vue';
import VueRouter from 'vue-router';
import Prices from "../Pages/Prices";
import Domains from "../Pages/Domains/Domains";
import Themes from "../Pages/Themes/Themes";

Vue.use(VueRouter);
const router = new VueRouter({
  mode: 'hash',
  routes: [
    {
      path: '/',
      component: Domains,
      name: 'Domains',
    },
    {
      path: '/prices',
      component: Prices,
      name: 'Prices',
    },{
      path: '/themes',
      component: Themes,
      name: 'Themes',
    },
  ]
});
export default router
