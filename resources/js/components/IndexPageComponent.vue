<template>
    <section style="background-color: black; margin-left: 60px; margin-right: 300px;">
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
                                Мы гарантируем свежесть продуктов и не используем замороженную рыбу
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
                            <h4>Рецепты от шеф-повара</h4>
                            <p>
                                Мы предлагаем как классические суши, так и авторские рецепты от шеф-повара
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
                            <h4>Качественные ингредиенты</h4>
                            <p>
                                Мы не используем усилители вкуса. Все продукты закупаем у проверенных поставщиков
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
                            <h4>Чистая кухня</h4>
                            <p>
                                Весь процесс приготовления проходит в соответствии со всеми санитарными нормами
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-3">
            <h1 class="text-white font-weight-bold">Топ позиції</h1>
            <div class="row">
                <p class="col-12 col-md-6 text-white">В ассортименте Ninja Sushi представлены роллы, суши, сеты и напитки на любой вкус. Мы рекомендуем обязательно попробовать топ позиции нашего меню!</p>
            </div>
            <carousel :navigation-enabled="true" :per-page="4">
                <slide class="px-3">
                    <img class="img-fluid" src="/img/default.png">
                    <h3 class="text-white text-center p-2">Slide Title</h3>
                    <p class="text-white text-justify">Slide Description</p>
                </slide>
                <slide class="px-3">
                    <img class="img-fluid" src="/img/default.png">
                    <h3 class="text-white text-center p-2">Slide Title</h3>
                    <p class="text-white text-justify">Slide Description</p>
                </slide>
                <slide class="px-3">
                    <img class="img-fluid" src="/img/default.png">
                    <h3 class="text-white text-center p-2">Slide Title</h3>
                    <p class="text-white text-justify">Slide Description</p>
                </slide>
                <slide class="px-3">
                    <img class="img-fluid" src="/img/default.png">
                    <h3 class="text-white text-center p-2">Slide Title</h3>
                    <p class="text-white text-justify">Slide Description</p>
                </slide>
                <slide class="px-3">
                    <img class="img-fluid" src="/img/default.png">
                    <h3 class="text-white text-center p-2">Slide Title</h3>
                    <p class="text-white text-justify">Slide Description</p>
                </slide>
                <slide class="px-3">
                    <img class="img-fluid" src="/img/default.png">
                    <h3 class="text-white text-center p-2">Slide Title</h3>
                    <p class="text-white text-justify">Slide Description</p>
                </slide>
            </carousel>
        </div>
    </section>
</template>
<script>
export default {
    data() {
        return {
            
        }
    },
    created() {
        
    },
}
</script>