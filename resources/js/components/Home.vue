<template>
    <div class="container py-5">
        <!--If products object received-->
        <div v-if="products !== null && !error" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col" v-for="product in products" :key="'pr' + product.id">
                <div class="card">
                    <img v-bind:src="product.img_url" class="card-img-top" alt="product">
                    <div class="card-body">
                        <h5 class="card-title" v-text="product.name"></h5>
                        <p class="fs-6 fw-light">Артикул: <span v-text="product.sku"></span></p>
                        <p class="card-text" v-text="product.description"></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <p v-text="product.price + currency" class="my-0 py-0 fw-bolder fs-5"></p>
                            <a @click="addItemToCart(product.id, product.name)" class="btn btn-primary">Купить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--If something went wrong-->
        <div v-if="error" class="text-center py-5">
            <h4>Что-то пошло не так</h4>
        </div>

        <!--Cart toast-->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-primary text-white">
                    <strong class="me-auto" v-text="addedProductName"></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-white">
                    Товар добавлен в корзину
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            products: null,
            loading: false, 
            currency: ' руб',
            error: false,
            token: token,
            addedProductName: ''
        }
    },
    created() {
        this.loading = true;
        this.axios.get('./app/api/product/read.php').then(response => {
            this.products = response.data;
            this.loading = false;
        }).catch(function (error) {
            if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Error', error.message);
            }
            this.loading = false;
            this.error = true;
            console.log(error.config);
        });
    },
    methods: {
        addItemToCart(id, name) {
            this.axios.post('./app/api/cart/add.php', JSON.stringify({
                product_id: id,
                qty: 1,
                token: token
            })).then(response => {
                // Refresh cart if an item has been added
                this.emitter.emit('cart-refresh', response.data.countItems);

                // Added product name
                this.addedProductName = name;

                // Show toast
                const cartToast = document.getElementById('cartToast');
                const toast = new bootstrap.Toast(cartToast);
                toast.show();
            }).catch(function (error) {
            if (error.response) {
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Error', error.message);
            }
            this.loading = false;
            this.error = true;
            console.log(error.config);
        });
        }
    }
}
</script>
