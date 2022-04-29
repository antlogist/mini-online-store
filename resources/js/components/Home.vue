<template>
    <div class="container py-5">

        <!--If products object received-->
        <div v-if="products !== null && !error" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

            <!--Products loop-->
            <div class="col" v-for="(product, index) in products" :key="product.sku">
                <div class="card">
                    <img v-bind:src="product.img_url" class="card-img-top" alt="product">
                    <div class="card-body">
                        <h5 class="card-title" v-text="product.name"></h5>
                        <p class="fs-6 fw-light">Артикул: <span v-text="product.sku"></span></p>
                        <p class="card-text" v-text="product.description"></p>

                        <div class="d-flex justify-content-between align-items-end mb-5">
                            
                            <!--price-->
                            <p v-text="product.price + currency" class="my-0 py-0 fw-bolder fs-5"></p>
                            <!--/price-->

                            <!--Quantity-->
                            <div>
                                <label for="productQuantity" class="form-label">Количество</label>
                                <input 
                                    v-model="qty[product.id]"
                                    type="number" 
                                    class="form-control" 
                                    id="productQuantity" 
                                    min="1" 
                                    max="1000" 
                                    style="max-width: 100px;">
                            </div>
                            <!--/Quantity-->
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <a @click="addItemToCart(product.id, product.name, index)" class="btn btn-primary">Добавить в корзину</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Product loop-->
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
                    Товар успешно добавлен
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
            addedProductName: '',
            qty: {}
        }
    },
    created() {
        this.loading = true;
        this.axios.get('./app/api/product/read.php').then(response => {
            this.products = response.data;
            this.products.map((product) => {
                this.qty[product.id] = 1;
            })
            this.loading = false;
        }).catch(function (error) {
            this.loading = false;
            this.error = true;
            console.log(error);
        });
    },
    methods: {
        addItemToCart(id, name) {
            this.axios.post('./app/api/cart/add.php', JSON.stringify({
                product_id: id,
                qty: this.qty[id],
                token: token
            })).then(response => {
                // Refresh cart if an item has been added
                this.emitter.emit('cart-refresh', response.data.countItems);

                // Reset qty
                this.qty[id] = 1

                // Added product name
                this.addedProductName = name;

                // Show toast
                const cartToast = document.getElementById('cartToast');
                const toast = new bootstrap.Toast(cartToast);
                toast.show();
            }).catch(function (error) {
                this.loading = false;
                this.error = true;
                console.log(error);
            });
        }
    },
    watch: {
        qty: {
            handler(obj) {
                Object.keys(obj).map((key) => {
                    if(this.qty[key] < 1) {
                        this.qty[key] = 1;
                    }
                    if(this.qty[key] > 1000) {
                        this.qty[key] = 1000;
                    }
                })
            },
            deep: true
        }
    }
}
</script>
