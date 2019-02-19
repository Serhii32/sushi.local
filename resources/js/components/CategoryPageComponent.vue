<template>
    <section style="min-height: 100vh; background-color: black; margin-left: 60px; margin-right: 370px;">
        <div class="container-fluid p-3">
            <h1 class="text-white font-weight-bold">{{category.title}}</h1>
            
            <b-tabs>
                <b-tab title="Всі" class="container-fluid">
                    <div class="row">

                        <div style="background-color: black;" class="px-3 card col-12 col-md-4" v-for="product in products" :key="product.id">
                            <a class="card-link" :href="'/product/' + product.id"><img class="img-fluid card-img-top" :src="product.photo?'/'+product.photo:'/img/default.png'"></a>
                            <div class="card-body">
                                <h4 class="text-center p-2 card-title"><a class="text-white card-link" :href="'/product/' + product.id">{{product.title}}</a></h4>
                                <p class="text-white card-text" style="text-overflow: ellipsis; overflow: hidden; height: 3em; white-space: nowrap;">
                                    <span class="font-weight-bold" style="color: #e16729">{{product.weight}}</span> - <span class="text-lowercase" v-for="component in product.components" :key="component.id">{{component.title}}, </span> 
                                </p>
                            </div>
                            <div class="card-footer">
                                <div>
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

                        <div style="background-color: black;" class="px-3 card col-12 col-md-4" v-for="product in products" :key="product.id" v-if="product.attributes.length && product.attributes.filter(attribute => attribute.id == tabIndex).length">
                            <a class="card-link" :href="'/product/' + product.id"><img class="img-fluid card-img-top" :src="product.photo?'/'+product.photo:'/img/default.png'"></a>
                            <div class="card-body">
                                <h4 class="text-center p-2 card-title"><a class="text-white card-link" :href="'/product/' + product.id">{{product.title}}</a></h4>
                                <p class="text-white card-text" style="text-overflow: ellipsis; overflow: hidden; height: 3em; white-space: nowrap;">
                                    <span class="font-weight-bold" style="color: #e16729">{{product.weight}}</span> - <span class="text-lowercase" v-for="component in product.components" :key="component.id">{{component.title}}, </span> 
                                </p>
                            </div>
                            <div class="card-footer">
                                <div>
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