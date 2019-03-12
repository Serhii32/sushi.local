<template>
    <section id="main-section">
        <div class="container-fluid p-1">
            <div class="row">
                <div class="col-12 col-lg-5 my-auto px-5">
                    <h2 class="text-white font-weight-bold">Доставка суші для істинних поціновувачів</h2>
                    <p class="text-white">Замовляйте суші преміум класу для всієї компанії додому та в офіс</p>
                    <b-button href="/menu" class="p-3 text-uppercase font-weight-bold" style="border-radius: 20px; background: #e16729; border-color: #e16729;">Зробити замовлення</b-button>
                </div>
                <div class="col-12 col-lg-7">
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
                            <h4>Якісні інгредієнти</h4>
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
            <h2 class="text-white font-weight-bold">Топ позиції</h2>
            <div class="row">
                <p class="col-12 col-md-6 text-white">В асортименті SushiWin представлені роли, суші, сети і напої на будь-який смак. Ми рекомендуємо обов'язково спробувати топ позиції нашого меню!</p>
            </div>

            <div class="p-2" v-for="category in categories" :key="category.id">
                <h3 class="text-white font-weight-bold">{{category.title}}</h3>

                <carousel pagination-color="#e16729" pagination-active-color="#fff" :navigation-enabled="true" :per-page-custom="[[0, 1], [768, 2], [992, 3]]">
                    <slide style="background-color: black;" class="product-slide px-3 card" v-for="product in category.products" :key="product.id">
                        <a class="card-link" :href="'/product/' + product.id"><img class="img-fluid card-img-top" :src="product.photo?'/'+product.photo:'/img/default.png'"></a>
                        <div class="card-body">
                            <h5 class="text-white text-center p-2 card-title"><a class="text-white card-link" :href="'/product/' + product.id">{{product.title}}</a></h5>
                            <p class="text-white card-text">
                                <span class="font-weight-bold" style="color: #e16729">{{product.weight}}</span> - <span class="text-lowercase" v-for="(component, index) in product.components" :key="component.id">{{component.title}}<span v-if="!(index == product.components.length - 1)">, </span></span>
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
    .product-slide:hover {
        border: 3px solid #e16729;
    }
</style>