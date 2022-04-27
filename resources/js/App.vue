<template>

    <div id="nav">
        <router-link to="/">Home</router-link> |
        <router-link to="/cart">Cart</router-link>
    </div>

  <router-view/>

</template>

<script>

import Home from './components/Home.vue';
import Cart from './components/Home.vue';

export default {
    data() {
        return {

        }
    },
    components: {
        Home,
        Cart
    }
}
</script>
