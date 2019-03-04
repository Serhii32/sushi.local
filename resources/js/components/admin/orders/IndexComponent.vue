<template>

    <div>
        <div v-for="order in orders" :key="order.id" class="my-3 h-100 shadow p-2 bg-white">
            <h3 class="text-left text-uppercase">
                Замовлення {{order.id}}
            </h3>

            <h6 class="text-left text-uppercase">Ім'я: {{order.name}}</h6>
            <h6 class="text-left" style="word-break: break-word;"><span class="text-uppercase">Email:</span> {{order.email}}</h6>
            <h6 class="text-left text-uppercase">Телефон: {{order.phone}}</h6>

            <h6 class="text-left text-uppercase">Вулиця: {{order.street}}</h6>
            <h6 class="text-left text-uppercase">Будинок: {{order.building}}</h6>
            <h6 class="text-left text-uppercase">Під'їзд: {{order.entrance}}</h6>
            <h6 class="text-left text-uppercase">Корпус: {{order.house}}</h6>
            <h6 class="text-left text-uppercase">Квартира: {{order.apartment}}</h6>
            <h6 class="text-left text-uppercase">Поверх: {{order.floor}}</h6>

            <h6 class="text-left text-uppercase">Дзвінок в двері: {{order.call?'Так':'Ні'}}</h6>

            <h6 class="text-left text-uppercase">Дата: {{order.date}}</h6>
            <h6 class="text-left text-uppercase">Час: {{order.time}}</h6>

            <h6 class="text-left text-uppercase">Оплата: {{order.payment?'Готівкою':'Онлайн картою'}}</h6>
            <h6 v-if="order.payment" class="text-left text-uppercase">Підготувати решту з: {{order.change}}</h6>
            <h6 v-else class="text-left text-uppercase">Статус онлайн оплати: {{order.paid?'Оплачено':'Не оплачено'}}</h6>

            <h6 class="text-left text-uppercase">Кількість персон: {{order.persons}}</h6>
            <h6 class="text-left text-uppercase">Тип паличок: {{order.sticks?'Звичайні':'Навчальні'}}</h6>
            <h6 class="text-left text-uppercase">Коментар: {{order.comment}}</h6>

           
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
            <b-button variant="danger" class="text-uppercase font-weight-bold my-2 w-100" @click="deleteOrder(order.id)">Видалити</b-button>
        </div>
    </div>

</template>
<script>
export default {
    data() {
        return {
            loaded: true,
            orders:{},
        }
    },
    created() {
        this.getOrders();
    },
    methods: {
        getOrders(){
            if (this.loaded) {
                this.loaded = false;
                axios.get('/admin/orders/getOrders').then(response => {
                    this.loaded = true;
                    this.orders = response.data.orders;
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
        deleteOrder (id) {
            if (this.loaded) {
                this.loaded = false;

                axios.post('/admin/orders/delete/'+id).then(() => {
                    this.loaded = true;
                    this.getOrders();
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });

            }
        },
    }
}
</script>