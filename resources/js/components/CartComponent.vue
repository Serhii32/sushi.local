<template>
   <aside class="position-fixed p-2" style="background-color: black; border-left: 3px solid #e16729; width: 370px; right: 0px; overflow-y: auto; height: calc(100vh - 100px);">
        <h5 class="text-white">Ваше замовлення:</h5>
        <div v-for="item in cart" :key="item.rowId" class="container-fluid my-2" style="border-bottom: 3px solid #e16729;">
            <div>
                <img width=15 class="d-inline float-right" src="/img/front/icons/close.svg" @click="removeItemFromCart(item.rowId)">
            </div>
            <div class="row m-0">
                <div class="col-12 col-md-6">
                    <p class="font-weight-bold text-white m-0">{{item.name}}</p>
                    <p class="font-weight-bold text-white m-0"><img width=15 class="d-inline" src="/img/front/icons/plus.svg" @click="updateQTY(item.rowId,++item.qty)"> {{item.qty}} <img width=15 class="d-inline" src="/img/front/icons/minus.svg"@click="item.qty>1?updateQTY(item.rowId,--item.qty):item.qty"></p>
                    <p class="font-weight-bold text-white m-0">{{item.qty * item.price}} грн</p>
                </div>
                <div class="col-12 col-md-6 m-auto">
                    <img class="img-fluid" :src="item.options.photo?'/'+item.options.photo:'/img/default.png'">
                </div>
            </div>
        </div>

         <form class="mt-3" @submit.prevent="submit">
            <div class="container-fluid">
                <h5 class="text-white">Персональні дані:</h5>
                <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть ваше ім'я">
                    <b-form-input id="name" name="name" :state="Boolean(errors && errors.name && errors.name[0])?false:null" type="text" placeholder="Ім'я" v-model="fields.name"></b-form-input>
                    <div v-if="errors && errors.name">
                        <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.name[0] }}</b-alert>
                    </div>
                </b-form-group>
                <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть ваш номер телефону">
                    <b-form-input id="phone" name="phone" :state="Boolean(errors && errors.phone && errors.phone[0])?false:null" type="tel" placeholder="Телефон" v-model="fields.phone"></b-form-input>
                    <div v-if="errors && errors.phone">
                        <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.phone[0] }}</b-alert>
                    </div>
                </b-form-group>
                <h5 class="text-white">Доставка:</h5>
                <h5 class="text-white text-center">Вінниця</h5>
                <div class="row">
                    <b-form-group class="col-12 col-md-6" description="Введіть назву вулиці">
                        <b-form-input id="street" name="street" :state="Boolean(errors && errors.street && errors.street[0])?false:null" type="text" placeholder="Вулиця" v-model="fields.street"></b-form-input>
                        <div v-if="errors && errors.street">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.street[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group class="col-12 col-md-6" description="Введіть номер будинку">
                        <b-form-input id="building" name="building" :state="Boolean(errors && errors.building && errors.building[0])?false:null" type="text" placeholder="Будинок" v-model="fields.building"></b-form-input>
                        <div v-if="errors && errors.building">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.building[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group class="col-12 col-md-6" description="Введіть номер під'їзду">
                        <b-form-input id="entrance" name="entrance" :state="Boolean(errors && errors.entrance && errors.entrance[0])?false:null" type="text" placeholder="Під'їзд" v-model="fields.entrance"></b-form-input>
                        <div v-if="errors && errors.entrance">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.entrance[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group class="col-12 col-md-6" description="Введіть номер корпусу">
                        <b-form-input id="house" name="house" :state="Boolean(errors && errors.house && errors.house[0])?false:null" type="text" placeholder="Корпус" v-model="fields.house"></b-form-input>
                        <div v-if="errors && errors.house">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.house[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group class="col-12 col-md-6" description="Введіть номер квартири">
                        <b-form-input id="apartment" name="apartment" :state="Boolean(errors && errors.apartment && errors.apartment[0])?false:null" type="text" placeholder="Квартира" v-model="fields.apartment"></b-form-input>
                        <div v-if="errors && errors.apartment">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.apartment[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group class="col-12 col-md-6" description="Введіть номер поверху">
                        <b-form-input id="floor" name="floor" :state="Boolean(errors && errors.floor && errors.floor[0])?false:null" type="text" placeholder="Поверх" v-model="fields.floor"></b-form-input>
                        <div v-if="errors && errors.floor">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.floor[0] }}</b-alert>
                        </div>
                    </b-form-group>
                </div>
                <b-form-group>
                    <b-form-checkbox id="call" class="text-white" name="call" :state="Boolean(errors && errors.call && errors.call[0])?false:null" v-model="fields.call" value="1" unchecked-value="null">Не дзвонити в двері</b-form-checkbox>
                    <div v-if="errors && errors.call">
                        <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.call[0] }}</b-alert>
                    </div>
                </b-form-group>
                
                <div class="row">
                    <b-form-group class="col-12 col-md-6" description="Виберіть дату доставки">
                        <b-form-select id="date" name="date" :state="Boolean(errors && errors.date && errors.date[0])?false:null" placeholder="Дата" v-model="fields.date" :options="dateOptions"></b-form-select>
                        <div v-if="errors && errors.date">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.date[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group class="col-12 col-md-6" description="Виберіть час доставки">
                        <b-form-select id="time" name="time" :state="Boolean(errors && errors.time && errors.time[0])?false:null" placeholder="Час" v-model="fields.time" :options="timeOptions"></b-form-select>
                        <div v-if="errors && errors.time">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.time[0] }}</b-alert>
                        </div>
                    </b-form-group>
                </div>

                <h5 class="text-white">Спосіб оплати</h5>

                <b-form-group>
                    <b-form-radio-group stacked class="text-white" id="payment" :state="Boolean(errors && errors.payment && errors.payment[0])?false:null" v-model="fields.payment" name="payment">
                        <b-form-radio value=1>Готівкою</b-form-radio>
                        <b-form-radio value=0>Онлайн картою</b-form-radio>
                    </b-form-radio-group>
                    <span>{{fields.payment}}</span>
                    <div v-if="errors && errors.payment">
                        <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.payment[0] }}</b-alert>
                    </div>
                </b-form-group>

                <b-form-group v-if="fields.payment == '1'" description="Підготувати решту з...">
                    <b-form-input id="change" name="change" :state="Boolean(errors && errors.change && errors.change[0])?false:null" type="text" placeholder="Решта з..." v-model="fields.change"></b-form-input>
                    <div v-if="errors && errors.change">
                        <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.change[0] }}</b-alert>
                    </div>
                </b-form-group>

                <h5 class="text-white">Всього: {{totalSum}}</h5>
                <b-form-group>
                    <b-button type="submit" class="btn btn-success w-100 text-uppercase font-weight-bold">Оформити</b-button>
                </b-form-group>
            </div>
        </form>

    </aside>
</template>
<script>
export default {
    data() {
        return {
            loaded: true,
            cart:{},
            errors: {},
            fields: {},
            totalSum: 0,
            dateOptions: [
                { value: Date.now(), text: 'Сьогодні' },
                { value: Date.now()+86400000, text: 'Завтра' },
                { value: Date.now()+172800000, text: new Date(Date.now()+172800000).getDate() + '.' + parseInt(new Date(Date.now()+172800000).getMonth()+1)},
                { value: Date.now()+259200000, text: new Date(Date.now()+259200000).getDate() + '.' + parseInt(new Date(Date.now()+259200000).getMonth()+1)},
                { value: Date.now()+345600000, text: new Date(Date.now()+345600000).getDate() + '.' + parseInt(new Date(Date.now()+345600000).getMonth()+1)},
            ],
            timeOptions: [
                { value: '11:00', text: '11:00' },
                { value: '11:15', text: '11:15' },
                { value: '11:30', text: '11:30' },
                { value: '11:45', text: '11:45' },
                { value: '12:00', text: '12:00' },
                { value: '12:15', text: '12:15' },
                { value: '12:30', text: '12:30' },
                { value: '12:45', text: '12:45' },
                { value: '13:00', text: '13:00' },
                { value: '13:15', text: '13:15' },
                { value: '13:30', text: '13:30' },
                { value: '13:45', text: '13:45' },
                { value: '14:00', text: '14:00' },
                { value: '14:15', text: '14:15' },
                { value: '14:30', text: '14:30' },
                { value: '14:45', text: '14:45' },
                { value: '15:00', text: '15:00' },
                { value: '15:15', text: '15:15' },
                { value: '15:30', text: '15:30' },
                { value: '15:45', text: '15:45' },
                { value: '16:00', text: '16:00' },
                { value: '16:15', text: '16:15' },
                { value: '16:30', text: '16:30' },
                { value: '16:45', text: '16:45' },
                { value: '17:00', text: '17:00' },
                { value: '17:15', text: '17:15' },
                { value: '17:30', text: '17:30' },
                { value: '17:45', text: '17:45' },
                { value: '18:00', text: '18:00' },
                { value: '18:15', text: '18:15' },
                { value: '18:30', text: '18:30' },
                { value: '18:45', text: '18:45' },
                { value: '19:00', text: '19:00' },
                { value: '19:15', text: '19:15' },
                { value: '19:30', text: '19:30' },
                { value: '19:45', text: '19:45' },
                { value: '20:00', text: '20:00' },
                { value: '20:15', text: '20:15' },
                { value: '20:30', text: '20:30' },
                { value: '20:45', text: '20:45' },
                { value: '21:00', text: '21:00' },
                { value: '21:15', text: '21:15' },
                { value: '21:30', text: '21:30' },
                { value: '21:45', text: '21:45' },
                { value: '22:00', text: '22:00' },
                { value: '22:15', text: '22:15' },
                { value: '22:30', text: '22:30' },
                { value: '22:45', text: '22:45' },
            ],
        }
    },
    created() {
        this.getCartContent();
    },
    mounted: function () { 
        this.$root.$on('cartUpdated', () => {
            this.getCartContent();
        });
    },
    methods: {
        getCartContent(){
            if (this.loaded) {
                this.loaded = false;
                axios.get('/getCartContent').then(response => {
                    this.loaded = true;
                    this.cart = response.data.cart;
                    this.getTotalSum();
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
        updateQTY(id,qty){
            if (this.loaded) {
                this.loaded = false;
                axios.post('/updateQTY', {id:id, qty:qty}).then(response => {
                    this.loaded = true;
                    this.getTotalSum();
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
        removeItemFromCart(id){
            if (this.loaded) {
                this.loaded = false;
                Vue.delete(this.cart, id);
                axios.post('/removeItemFromCart', {id:id}).then(response => {
                    this.loaded = true;
                    this.getTotalSum();
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
        getTotalSum(){
            this.totalSum = 0;
            for(var index in this.cart){
                this.totalSum += parseInt(this.cart[index].qty) * parseFloat(this.cart[index].price);
            }
        },
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.errors = {};
            //     let formData = new FormData();
            //     formData.set('title', this.fields.title == null?"":this.fields.title);
            //     formData.set('price', this.fields.price == null?"":this.fields.price);
            //     formData.set('weight', this.fields.weight == null?"":this.fields.weight);
            //     formData.set('category', this.fields.category == null?"":this.fields.category);
            //     formData.set('attributes', this.fields.attributes == null || this.fields.attributes.length == 0?"":this.fields.attributes);
            //     formData.set('components', this.fields.components == null || this.fields.components.length == 0?"":this.fields.components);
            //     formData.set('titleSEO', this.fields.titleSEO == null?"":this.fields.titleSEO);
            //     formData.set('descriptionSEO', this.fields.descriptionSEO == null?"":this.fields.descriptionSEO);
            //     formData.set('keywordsSEO', this.fields.keywordsSEO == null?"":this.fields.keywordsSEO);
            //     formData.append('photo', this.fields.photo == null?"":this.fields.photo);
            //     axios.post('/admin/products', formData, {'Content-Type': 'multipart/form-data'}).then(response => {
            //         this.loaded = true;
            //         this.hideCreateModal();
            //         this.resetImage();
            //         this.fields = {
            //             'attributes': [],
            //             'components': [],
            //         };
            //         let page = this.products.last_page;
            //         this.getProducts(page);
            //     }).catch(error => {
            //         this.loaded = true;
            //         if (error.response.status === 422) {
            //             this.errors = error.response.data.errors || {};
            //         }
            //     });
            }
        },
    }
}
</script>