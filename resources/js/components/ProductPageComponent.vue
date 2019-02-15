<template>
    <section style="min-height: 100vh; background-color: black; margin-left: 60px; margin-right: 300px;">
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col-12 col-md-6">
                    <img class="img-fluid" :src="product.photo?'/'+product.photo:'/img/default.png'">
                </div>
                <div class="col-12 col-md-6">
                    <h1 class="text-white font-weight-bold">
                        {{product.title}} <span>{{product.price}} грн.</span>
                    </h1>
                    <h4 class="font-weight-bold" style="color: #e16729">
                        {{product.weight}}
                    </h4>
                    <h5 class="text-white">
                        Склад:
                    </h5>
                    <carousel :pagination-enabled="false" :per-page-custom="[[768, 2], [992, 3], [1199, 4]]">
                        <slide style="background-color: black;" class="px-3 card" v-for="component in components" :key="component.id">
                            <img class="img-fluid card-img-top" :src="component.photo?'/'+component.photo:'/img/default.png'">
                            <h5 class="text-white text-center p-2 card-title">{{component.title}}</h5>
                        </slide>
                    </carousel>
                    <div class="container-fluid">
                        <b-button class="text-uppercase font-weight-bold w-100" style="border-radius: 20px; background: #e16729; border-color: #e16729;" @click="addToCart(product.id)">В корзину</b-button>
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