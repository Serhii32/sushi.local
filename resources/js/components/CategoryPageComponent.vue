<template>
    <section id="main-section">
        <div class="container-fluid p-3">
            <h1 class="text-white font-weight-bold">{{category.title}}</h1>
            
            <b-tabs>
                <b-tab title="Всі" class="container-fluid">
                    <div class="row">

                        <div style="background-color: black;" class="px-3 card col-12 col-md-4" v-for="product in reactiveProducts" :key="product.id">
                            <a class="card-link" :href="'/product/' + product.id"><img class="img-fluid card-img-top" :src="product.photo?'/'+product.photo:'/img/default.png'"></a>
                            <div class="card-body">
                                <h4 class="text-center p-2 card-title"><a class="text-white card-link" :href="'/product/' + product.id">{{product.title}}</a></h4>
                                <p class="text-white card-text">
                                    <span class="font-weight-bold" style="color: #e16729">{{product.weight}}</span> - <span class="text-lowercase" v-for="component in product.components" :key="component.id">{{component.title}}, </span> 
                                </p>
                            </div>
                            <div class="card-footer">
                                <div>
                                    <img id="favorite-button" style="position: absolute; width: 30px; top: 0px; left: 0px;" :src="product.isFavorite?'/img/front/icons/favorite-filled.svg':'/img/front/icons/favorite.svg'" @click="addToFavorites(product)">
                                    <b-button class="text-uppercase font-weight-bold w-100" style="border-radius: 20px; background: #e16729; border-color: #e16729;" @click="addToCart(product.id)">В корзину</b-button>
                                </div>
                                <div class="p-2">
                                    <h5 class="text-white text-center card-text font-weight-bold" style="color: #e16729">{{product.price}} грн.</h5>                                
                                </div>
                            </div>
                        </div>

                    </div>
                </b-tab>

                <b-tab v-for="(tab, tabIndex) in tabs" :key="tabIndex" :title="tab" class="container-fluid">
                    <div class="row">

                        <div style="background-color: black;" class="px-3 card col-12 col-md-4" v-for="product in reactiveProducts" :key="product.id" v-if="product.attributes.length && product.attributes.filter(attribute => attribute.id == tabIndex).length">
                            <a class="card-link" :href="'/product/' + product.id"><img class="img-fluid card-img-top" :src="product.photo?'/'+product.photo:'/img/default.png'"></a>
                            <div class="card-body">
                                <h3 class="text-center p-2 card-title"><a class="text-white card-link" :href="'/product/' + product.id">{{product.title}}</a></h3>
                                <p class="text-white card-text">
                                    <span class="font-weight-bold" style="color: #e16729">{{product.weight}}</span> - <span class="text-lowercase" v-for="component in product.components" :key="component.id">{{component.title}}, </span> 
                                </p>
                            </div>
                            <div class="card-footer">
                                <div>
                                    <img id="favorite-button" style="position: absolute; width: 30px; top: 0px; left: 0px;" :src="product.isFavorite?'/img/front/icons/favorite-filled.svg':'/img/front/icons/favorite.svg'" @click="addToFavorites(product)">
                                    <b-button class="text-uppercase font-weight-bold w-100" style="border-radius: 20px; background: #e16729; border-color: #e16729;" @click="addToCart(product.id)">В корзину</b-button>
                                </div>
                                <div class="p-2">
                                    <h5 class="text-white text-center card-text font-weight-bold" style="color: #e16729">{{product.price}} грн.</h5>                                
                                </div>
                            </div>
                        </div>

                    </div>
                </b-tab>
                
            </b-tabs>

        </div>
    </section>
</template>
<script>
export default {
    props: [
        'category',
        'tabs',
        'checkboxes',
        'products'
    ],
    data() {
        return {
            loaded: true,
            reactiveProducts: this.products
        }
    },
    methods: {
        addToCart(id){
            if (this.loaded) {
                this.loaded = false;
    
                axios.post('/addToCart', {id:id}).then(response => {
                    this.loaded = true;

                    this.$root.$emit('cartUpdated');

                }).catch(error => {
                    this.loaded = true;
                });
            }
        },
        addToFavorites(product){
            if (this.loaded) {
                this.loaded = false;

                product.isFavorite = product.isFavorite?false:true;
    
                axios.post('/addToFavorites', {id:product.id}).then(response => {
                    this.loaded = true;
                    if (typeof response.data.redirect !== 'undefined') {
                        window.location.href = response.data.redirect;
                    }
                }).catch(error => {
                    this.loaded = true;
                });
            }
        }
    }
}
</script>
<style>
    .nav-tabs {
        border-bottom: 5px solid #e16729;
    }
    .nav-tabs .nav-link {
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }
    .nav-tabs .nav-link:hover, .nav-tabs .nav-link:focus {
        border-color: transparent;
    }
    .nav-tabs .nav-link.active {
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        background-color: #e16729;
        border-color: #e16729;
    }
</style>