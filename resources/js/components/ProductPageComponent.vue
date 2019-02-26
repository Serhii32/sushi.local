<template>
    <section id="main-section">
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-12 col-md-6">
                    <img class="img-fluid" :src="product.photo?'/'+product.photo:'/img/default.png'">
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
                        <slide style="background-color: black; max-width: 105px;" class="px-3 card" v-for="component in components" :key="component.id" v-if="component.photo">
                            <img class="img-fluid card-img-top" :src="component.photo?'/'+component.photo:'/img/default.png'">
                            <p style="font-size: 12px;" class="text-white text-center card-title">{{component.title}}</p>
                        </slide>
                    </carousel>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <b-button class="text-uppercase font-weight-bold w-100" style="border-radius: 20px; background: #e16729; border-color: #e16729;" @click="addToCart(product.id)">В корзину</b-button>
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
        }
    }
}
</script>