<template>
   <aside class="position-fixed p-2" style="background-color: black; border-left: 3px solid #e16729; width: 370px; right: 0px; overflow-y: auto; height: 90vh;">
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
                    <b-form-checkbox id="call" name="call" :state="Boolean(errors && errors.call && errors.call[0])?false:null" v-model="fields.call" value="1" unchecked-value="null">Не дзвонити в двері</b-form-checkbox>
                    <div v-if="errors && errors.call">
                        <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.call[0] }}</b-alert>
                    </div>
                </b-form-group>


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
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
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