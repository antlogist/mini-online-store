<template>

    <!--Top bar-->
    <div class="bg-dark py-1">
        <div class="container navbar-top d-flex justify-content-between align-items-center">
            <div><a class="text-decoration-none link-light" href="tel:+71234567890" >+7-123-456-78-90</a></div>
            <div>
                <button @click="getCartItems" type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart mb-1 me-1" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <span class="d-inline-block fs-6" v-text="countItems"></span>
                </button>
            </div>
        </div>
    </div>
    <!--/Top bar-->

    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">

            <router-link class="navbar-brand text-uppercase" to="/mini-store">Магазин</router-link> 

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/mini-store">Домой</router-link> 
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/mini-store">Ссылка</router-link> 
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/mini-store">Ссылка</router-link> 
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/mini-store">Ссылка</router-link> 
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/mini-store">Ссылка</router-link> 
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ссылка
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark bg-primary" aria-labelledby="navbarDropdownMenuLink">
                            <li><router-link class="dropdown-item" to="/mini-store">Ссылка</router-link> </li>
                            <li><router-link class="dropdown-item" to="/mini-store">Ссылка</router-link> </li>
                            <li><router-link class="dropdown-item" to="/mini-store">Ссылка</router-link> </li>
                            <li><router-link class="dropdown-item" to="/mini-store">Ссылка</router-link> </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!--/Navbar-->

    <!--Router view-->
    <router-view/>
    <!--/Router view-->

    <!--Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Корзина покупок</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Изображение</th>
                                <th scope="col">Артикул</th>
                                <th scope="col">Наименование</th>
                                <th scope="col">Цена за единицу, руб.</th>
                                <th scope="col">Кол-во</th>
                                <th scope="col">Общая стоимость, руб.</th>
                            </tr>
                        </thead>
                        <tbody v-if="countItems > 0">
                            <tr v-for="(item, index) in cartItems" :key="item.id">
                                <td v-text="++index"></td>
                                <td>
                                    <img :src="item.img_url" class="img-thumbnail" style="max-width: 100px;" alt="product">
                                </td>
                                <td v-text="item.sku"></td>
                                <td v-text="item.name"></td>
                                <td v-text="item.price"></td>
                                <td v-text="item.qty"></td>
                                <td v-text="item.total_price"></td>
                            </tr>
                        </tbody>
                        <tbody v-else-if="success === false" class="text-center">
                            <td colspan="7">
                                <h5 class="py-5">Ваша корзина пуста</h5>
                            </td>
                        </tbody>
                        <tbody v-else-if="success === true" class="text-center">
                            <td colspan="7">
                                <h5 class="py-5" v-text="cartMessage"></h5>
                            </td>
                        </tbody>
                    </table>
                    <h1 v-text="cartTotal + currency"></h1>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button :disabled="countItems < 1" type="button" class="btn btn-primary" @click="createOrder">Оформить заказ</button>
                </div>
            </div>
        </div>
    </div>
    <!--/Modal -->

</template>

<script>

export default {
    data() {
        return {
            countItems: 0,
            cartItems: [],
            cartTotal: 0,
            currency: ' руб',
            cartMessage: '',
            success: false
        }
    },
    mounted() {
        this.emitter.on('cart-refresh', countItems => {
            this.countItems = countItems;
        });
        this.countItems = countItemsOnLoad;
    },
    methods: {
        getCartItems() {
            if(this.countItems <= 0) {
                return;
            }
            this.axios.get('./app/api/cart/read.php').then(response => {
                this.cartItems = response.data.items;
                // Sort cart items
                this.cartItems.sort((a, b) => a.sort_index > b.sort_index ? 1 : -1);
                this.cartTotal = response.data.cartTotal;
            }).catch(function (error) {
                console.log(error);
            });
        },
        createOrder() {
            this.axios.post('./app/api/order/create.php', JSON.stringify({
                token: token
            })).then(response => {
                // Refresh cart if an item has been added
                this.countItems = 0;
                this.cartItems = [];
                this.cartTotal = 0;
                this.success = true;

                if(response['data'].success) {
                    this.cartMessage = response['data'].success;
                } else {
                    this.cartMessage = response['data'].fail;
                }

            }).catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>
