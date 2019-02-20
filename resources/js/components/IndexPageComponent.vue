<template>
    <section style="background-color: black; margin-left: 60px; margin-right: 370px;">
        <div class="container-fluid p-1">
            <div class="row">
                <div class="col-12 col-lg-4 my-auto px-5">
                    <h1 class="text-white font-weight-bold">Доставка суші для істинних поціновувачів</h1>
                    <p class="text-white">Замовляйте суші преміум класу для всієї компанії додому та в офіс</p>
                    <b-button class="p-3 text-uppercase font-weight-bold" style="border-radius: 20px; background: #e16729; border-color: #e16729;">Зробити замовлення</b-button>
                </div>
                <div class="col-12 col-lg-8">
                    <img class="img-fluid" src="/img/front/index-page-main.jpg">
                </div>
            </div>
        </div>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3 text-center">
                    <div class="row">
                        <div class="col-3 col-lg-12 my-auto">
                            <img class="img-fluid" src="/img/front/icons/icon1.svg">
                        </div>
                        <div class="col-9 col-lg-12 text-white">
                            <h4>Fresh Made</h4>
                            <p>
                                Ми гарантуємо свіжість продуктів і не використовуємо заморожену рибу
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 text-center">
                    <div class="row">
                        <div class="col-3 col-lg-12 my-auto">
                            <img class="img-fluid" src="/img/front/icons/icon2.svg">
                        </div>
                        <div class="col-9 col-lg-12 text-white">
                            <h4>Рецепти від шеф-повара</h4>
                            <p>
                                Ми пропонуємо як класичні суші, так і авторські рецепти від шеф-повара
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 text-center">
                    <div class="row">
                        <div class="col-3 col-lg-12 my-auto">
                            <img class="img-fluid" src="/img/front/icons/icon3.svg">
                        </div>
                        <div class="col-9 col-lg-12 text-white">
                            <h4>Якісні інгрідієнти</h4>
                            <p>
                                Ми не використовуємо підсилювачі смаку. Всі продукти закуповуємо у перевірених постачальників
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 text-center">
                    <div class="row">
                        <div class="col-3 col-lg-12 my-auto">
                            <img class="img-fluid" src="/img/front/icons/icon4.svg">
                        </div>
                        <div class="col-9 col-lg-12 text-white">
                            <h4>Чиста кухня</h4>
                            <p>
                                Весь процес приготування проходить у відповідності з усіма санітарними нормами
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-3">
            <h1 class="text-white font-weight-bold">Топ позиції</h1>
            <div class="row">
                <p class="col-12 col-md-6 text-white">В асортименті SushiWin представлені роли, суші, сети і напої на будь-який смак. Ми рекомендуємо обов'язково спробувати топ позиції нашого меню!</p>
            </div>

            <div class="p-2" v-for="category in categories" :key="category.id">
                <h2 class="text-white font-weight-bold">{{category.title}}</h2>

                <carousel :navigation-enabled="true" :per-page-custom="[[768, 2], [992, 3], [1199, 4]]">
                    <slide style="background-color: black;" class="product-slide px-3 card" v-for="product in category.products" :key="product.id">
                        <a class="card-link" :href="'/product/' + product.id"><img class="img-fluid card-img-top" :src="product.photo?'/'+product.photo:'/img/default.png'"></a>
                        <div class="card-body">
                            <h4 class="text-white text-center p-2 card-title"><a class="text-white card-link" :href="'/product/' + product.id">{{product.title}}</a></h4>
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
                    </slide>
                </carousel>
            </div>

        </div>
    </section>
</template>
<script>
export default {
    data() {
        return {
            categories: {},
            loaded: true,
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories(){
            if (this.loaded) {
                this.loaded = false;
                axios.get('/getCategories').then(response => {
                    this.loaded = true;
                    this.categories = response.data.categories;
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
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
    .product-slide:hover {
        border: 3px solid #e16729;
    }
</style>