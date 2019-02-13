<template>
    <section style="min-height: 100vh; background-color: black; margin-left: 60px; margin-right: 300px;">
        <div class="container-fluid p-3">
            <h1 class="text-white font-weight-bold">{{category.title}}</h1>
            
            <b-tabs>
                sdsddsd
                <b-tab v-for="(tab, index) in tabs" :key="index" :title="tab">
                    <br>I'm the first fading tab
                </b-tab>
                
            </b-tabs>

           <!--  <div v-for="category in categories" :key="category.id">
                <h2 class="text-white font-weight-bold">{{category.title}}</h2>

                <carousel :navigation-enabled="true" :per-page-custom="[[768, 2], [992, 3], [1199, 4]]">
                    <slide style="background-color: black;" class="px-3 card" v-for="product in category.products" :key="product.id">
                        <img class="img-fluid card-img-top" :src="product.photo">
                        <div class="card-body">
                            <h4 class="text-white text-center p-2 card-title">{{product.title}}</h4>
                            <p class="text-white card-text" style="text-overflow: ellipsis; overflow: hidden; height: 3em; white-space: nowrap;">
                                <span class="font-weight-bold" style="color: #e16729">{{product.weight}}</span> - <span v-for="component in product.components" :key="component.id">{{component.title}} </span> 
                            </p>
                        </div>
                        <div class="card-footer">
                            <div>
                                <b-button class="text-uppercase font-weight-bold w-100" style="border-radius: 20px; background: #e16729; border-color: #e16729;">В корзину</b-button>
                            </div>
                            <div class="p-2">
                                <h5 class="text-white text-center card-text font-weight-bold" style="color: #e16729">{{product.price}} грн.</h5>                                
                            </div>
                        </div>
                    </slide>
                </carousel>
            </div>  -->

        </div>
    </section>
</template>
<script>
export default {
    props: [
        'category',
        'tabs',
        'checkboxes'
    ],
    data() {
        return {
            loaded: true,
        }
    },
    created() {
        console.log(this.tabs);
    },
    methods: {
        
    }
}
</script>