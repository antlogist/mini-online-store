<template>

    <!--Top bar-->
    <div class="bg-dark py-1">
        <div class="container navbar-top d-flex justify-content-between align-items-center">
            <div><a class="text-decoration-none link-light" href="tel:+71234567890" >+7-123-456-78-90</a></div>
            <div>
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
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

            <router-link class="navbar-brand text-uppercase" to="/">Магазин</router-link> 

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Домой</router-link> 
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/cart">Корзина</router-link> 
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Ссылка</router-link> 
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Ссылка</router-link> 
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Ссылка</router-link> 
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ссылка
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark bg-primary" aria-labelledby="navbarDropdownMenuLink">
                            <li><router-link class="dropdown-item" to="/">Ссылка</router-link> </li>
                            <li><router-link class="dropdown-item" to="/">Ссылка</router-link> </li>
                            <li><router-link class="dropdown-item" to="/">Ссылка</router-link> </li>
                            <li><router-link class="dropdown-item" to="/">Ссылка</router-link> </li>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
            countItems: 0
        }
    },
    mounted() {
        this.emitter.on('cart-refresh', countItems => {
            this.countItems = countItems;
        });
        this.countItems = countItemsOnLoad;
    }
}
</script>
