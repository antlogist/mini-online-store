<template>
    <div class="container py-5">
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
                            <a href="#" class="btn btn-primary">Купить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="error" class="text-center py-5">
            <h4>Что-то пошло не так</h4>
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
            error: false
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
}
</script>
