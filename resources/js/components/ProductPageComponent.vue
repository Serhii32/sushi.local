<template>
    <section id="main-section">
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-12 col-md-6">
                    <img class="img-fluid" :src="product.photo?'/'+product.photo:'/img/default.png'">
                    <img id="favorite-button" style="position: absolute; width: 30px; top: 0px; left: 0px;" :src="reactiveProduct.isFavorite?'/img/front/icons/favorite-filled.svg':'/img/front/icons/favorite.svg'" @click="addToFavorites(reactiveProduct)">
                </div>
                <div class="col-12 col-md-6">
                    <h1 class="text-white font-weight-bold">
                        {{product.title}}
                    </h1>
                    <h4 class="font-weight-bold" style="color: #e16729">
                        {{product.weight}}
                    </h4>
                    <h5 class="text-white">
                        Склад:
                    </h5>
                    <carousel :navigation-enabled="true" :pagination-enabled="false" :per-page-custom="[[768, 2], [992, 3], [1199, 4]]">
                        <slide style="background-color: black; max-width: 85px;" class="mx-3 card" v-for="component in components" :key="component.id" v-if="component.photo">
                            <img class="img-fluid card-img-top" :src="component.photo?'/'+component.photo:'/img/default.png'">
                            <p style="font-size: 12px;" class="text-white text-center card-title">{{component.title}}</p>
                        </slide>
                    </carousel>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <b-button class="text-uppercase font-weight-bold w-100" style="border-radius: 20px; background: #e16729; border-color: #e16729;" @click="addToCart(product.id, product.title, product.price)">В корзину</b-button>
                            </div>
                            <div class="col-12 col-md-6">
                                <h3 class="text-white font-weight-bold">{{product.price}} грн.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: [
        'product',
        'components'
    ],
    data() {
        return {
            loaded: true,
            reactiveProduct: this.product
        }
    },
    mounted() {
        gtag('event', 'view_item', {
          "items": [
            {
              "id": this.product.id,
              "name": this.product.title,
              "price": this.product.price
            }
          ]
        });
    },
    methods: {
        addToCart(id){
            if (this.loaded) {
                this.loaded = false;
    
                axios.post('/addToCart', {id:id}).then(response => {
                    this.loaded = true;
                    this.$root.$emit('cartUpdated');
                    gtag('event', 'add_to_cart', {
                      "items": [
                        {
                          "id": id,
                          "name": title,
                          "price": price
                        }
                      ]
                    });
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