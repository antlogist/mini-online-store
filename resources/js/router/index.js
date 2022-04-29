import { createRouter, createWebHistory } from 'vue-router';

import Home from '../components/Home.vue';
import Cart from '../components/Cart.vue';

const routes = [
    {
        path: '/mini-store',
        name: 'Home',
        component: Home
    },
    {
        path: '/mini-store/cart',
        name: 'Cart',
        component: Cart
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
  })
  export default router