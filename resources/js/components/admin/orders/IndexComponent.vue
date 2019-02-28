<template>

    <div>
        <div v-for="order in orders" :key="order.id" class="my-3 h-100 shadow p-2 bg-white">
            <h3 class="text-left text-uppercase">
                Замовлення {{order.id}}
            </h3>

            <h4 class="text-left text-uppercase">Имя: {{order.name}}</h4>
            <h4 class="text-left" style="word-break: break-word;"><span class="text-uppercase">Email:</span> {{order.email}}</h4>
            <h4 class="text-left text-uppercase">Телефон: {{order.phone}}</h4>

            <h4 class="text-left text-uppercase">Вулиця: {{order.street}}</h4>
            <h4 class="text-left text-uppercase">Будинок: {{order.building}}</h4>
            <h4 class="text-left text-uppercase">Під'їзд: {{order.entrance}}</h4>
            <h4 class="text-left text-uppercase">Корпус: {{order.house}}</h4>
            <h4 class="text-left text-uppercase">Квартира: {{order.apartment}}</h4>
            <h4 class="text-left text-uppercase">Поверх: {{order.floor}}</h4>
           
            <div v-for="product in order.products">
                <div class="row border-bottom p-1">
                    <div class="col-12 col-lg-2 pb-2 text-center">
                        <img class="img-fluid img-thumbnail" style="max-height: 100px;" :src="product.photo?'/'+product.photo:'/img/default.png'" :alt="product.title">
                    </div>
                    <div class="col-6 col-lg-3 text-dark font-weight-bold text-uppercase pb-2">
                        <p>Назва:</p>
                        <a :href="'/product/' + product.id">{{product.title}}</a>
                    </div>
                    <div class="col-6 col-lg-2 text-dark font-weight-bold text-uppercase pb-2">
                        <p>Ціна:</p>
                        {{product.pivot.price}}
                    </div>
                    <div class="col-6 col-lg-2 text-dark font-weight-bold text-uppercase pb-2">
                        <p>Кількість:</p>
                        {{product.pivot.quantity}}
                    </div>
                    <div class="col-6 col-lg-2 text-dark font-weight-bold text-uppercase pb-2">
                        <p>Всього:</p>
                        {{product.pivot.price * product.pivot.quantity}}
                    </div>
                </div>
            </div>

            <h4 class="text-left text-uppercase">Всього: {{order.totalSum}}</h4>

        </div>
    </div>

</template>
<script>
export default {
    props: [
        'orders',
    ],
}
</script>