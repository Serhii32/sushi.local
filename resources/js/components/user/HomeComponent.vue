<template>
    <section>
        <div class="container-fluid p-3">
            
            <b-tabs>
                <b-tab title="Персональні дані" class="container-fluid">
                    <form @submit.prevent="submit" class="py-4">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="text-center">
                                        <div v-if="uploadedImageData">
                                            <img class="img-thumbnail img-fluid" :src="uploadedImageData" :alt="old_datas.userName">
                                        </div>
                                        <div v-else-if="old_datas.avatar">
                                            <img class="img-thumbnail img-fluid" :src="'/'+old_datas.avatar" :alt="old_datas.userName">
                                        </div>
                                        <div v-else>
                                            <img class="img-thumbnail img-fluid" src="/img/avatars/default.png" :alt="old_datas.userName">
                                        </div>
                                    </div>


                                    <div class="form-group py-4">
                                        <label for="avatar" class="text-uppercase font-weight-bold text-white">Вибрати фото користувача:</label>
                                        <b-form-file v-model="fields.avatar" :state="Boolean(errors.avatar)?!Boolean(errors.avatar):null" placeholder="Фото" @change="previewImage" accept="image/*" ref="fileinput"></b-form-file>
                                        <div v-if="errors && errors.avatar">
                                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.avatar[0] }}</b-alert>
                                        </div>
                                        <a class="btn btn-warning w-100 text-uppercase font-weight-bold my-2" @click="resetImage">Зкинути зображення</a>
                                    </div>


                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="userName" class="text-uppercase font-weight-bold text-white">Ім'я:</label>
                                        <input id="userName" type="text" name="userName" placeholder="Ім'я" class="form-control" v-model="fields.userName" v-bind:class="{ 'is-invalid': errors && errors.userName && errors.userName[0] }">
                                        <div v-if="errors && errors.userName">
                                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.userName[0] }}</b-alert>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="text-uppercase font-weight-bold text-white">Email:</label>
                                        <input id="email" type="email" name="email" placeholder="Email" class="form-control" v-model="fields.email" v-bind:class="{ 'is-invalid': errors && errors.email && errors.email[0] }">
                                        <div v-if="errors && errors.email">
                                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.email[0] }}</b-alert>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="userPhone" class="text-uppercase font-weight-bold text-white">Телефон:</label>
                                        <input id="userPhone" type="number" name="userPhone" placeholder="Телефон" class="form-control" v-model="fields.userPhone" v-bind:class="{ 'is-invalid': errors && errors.userPhone && errors.userPhone[0] }">
                                        <div v-if="errors && errors.userPhone">
                                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.userPhone[0] }}</b-alert>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <b-form-group class="text-uppercase font-weight-bold text-white" label="Стать:">
                                            <b-form-radio-group buttons button-variant="outline-primary" class="d-flex" v-model="fields.gender" stacked :options="[{ text: 'Чоловіча', value: '1' },{ text: 'Жіноча', value: '0' }]" />
                                        </b-form-group>
                                        <div v-if="errors && errors.gender">
                                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.gender[0] }}</b-alert>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <b-form-group class="col-12 col-md-6" description="Введіть назву вулиці">
                                            <b-form-input id="userStreet" name="userStreet" :state="Boolean(errors && errors.userStreet && errors.userStreet[0])?false:null" type="text" placeholder="Вулиця" v-model="fields.userStreet"></b-form-input>
                                            <div v-if="errors && errors.userStreet">
                                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.userStreet[0] }}</b-alert>
                                            </div>
                                        </b-form-group>
                                        <b-form-group class="col-12 col-md-6" description="Введіть номер будинку">
                                            <b-form-input id="userBuilding" name="userBuilding" :state="Boolean(errors && errors.userBuilding && errors.userBuilding[0])?false:null" type="text" placeholder="Будинок" v-model="fields.userBuilding"></b-form-input>
                                            <div v-if="errors && errors.userBuilding">
                                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.userBuilding[0] }}</b-alert>
                                            </div>
                                        </b-form-group>
                                        <b-form-group class="col-12 col-md-6" description="Введіть номер під'їзду">
                                            <b-form-input id="userEntrance" name="userEntrance" :state="Boolean(errors && errors.userEntrance && errors.userEntrance[0])?false:null" type="text" placeholder="Під'їзд" v-model="fields.userEntrance"></b-form-input>
                                            <div v-if="errors && errors.userEntrance">
                                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.userEntrance[0] }}</b-alert>
                                            </div>
                                        </b-form-group>
                                        <b-form-group class="col-12 col-md-6" description="Введіть номер корпусу">
                                            <b-form-input id="userHouse" name="userHouse" :state="Boolean(errors && errors.userHouse && errors.userHouse[0])?false:null" type="text" placeholder="Корпус" v-model="fields.userHouse"></b-form-input>
                                            <div v-if="errors && errors.userHouse">
                                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.userHouse[0] }}</b-alert>
                                            </div>
                                        </b-form-group>
                                        <b-form-group class="col-12 col-md-6" description="Введіть номер квартири">
                                            <b-form-input id="userApartment" name="userApartment" :state="Boolean(errors && errors.userApartment && errors.userApartment[0])?false:null" type="text" placeholder="Квартира" v-model="fields.userApartment"></b-form-input>
                                            <div v-if="errors && errors.userApartment">
                                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.userApartment[0] }}</b-alert>
                                            </div>
                                        </b-form-group>
                                        <b-form-group class="col-12 col-md-6" description="Введіть номер поверху">
                                            <b-form-input id="userFloor" name="userFloor" :state="Boolean(errors && errors.userFloor && errors.userFloor[0])?false:null" type="text" placeholder="Поверх" v-model="fields.userFloor"></b-form-input>
                                            <div v-if="errors && errors.userFloor">
                                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.userFloor[0] }}</b-alert>
                                            </div>
                                        </b-form-group>
                                    </div>

                                    <div class="form-group">
                                        <label for="current_password" class="text-uppercase font-weight-bold text-white">Поточний пароль:</label>
                                        <input id="current_password" type="password" name="current_password" autocomplete="off" placeholder="Поточний пароль" class="form-control" v-model="fields.current_password" v-bind:class="{ 'is-invalid': errors && errors.current_password && errors.current_password[0] }">
                                        <div v-if="errors && errors.current_password">
                                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.current_password[0] }}</b-alert>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="text-uppercase font-weight-bold text-white">Новий пароль:</label>
                                        <input id="password" type="password" name="password" autocomplete="off" placeholder="Новий пароль" class="form-control" v-model="fields.password" v-bind:class="{ 'is-invalid': errors && errors.password && errors.password[0] }">
                                        <div v-if="errors && errors.password">
                                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.password[0] }}</b-alert>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation" class="text-uppercase font-weight-bold text-white">Підтвердити пароль:</label>
                                        <input id="password_confirmation" type="password" autocomplete="off" name="password_confirmation" placeholder="Підтвердити пароль" class="form-control" v-model="fields.password_confirmation" v-bind:class="{ 'is-invalid': errors && errors.password && errors.password[0] }">
                                        <div v-if="errors && errors.password">
                                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.password[0] }}</b-alert>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success w-100 text-uppercase font-weight-bold">Зберегти</button>
                                    </div>
                                    <div v-if="success">
                                        <b-alert class="text-center" variant="success" dismissible fade :show="true">Дані успішно оновлено</b-alert>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </b-tab>

                <b-tab title="Замовлення" class="container-fluid">
                    
                     <div v-for="order in orders" :key="order.id" class="my-3 h-100 shadow p-2 bg-white">
                        <h3 class="text-left text-uppercase">
                            Замовлення {{order.id}}
                        </h3>
                       
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
                    
                </b-tab>

                <b-tab title="Улюблені" class="container-fluid">
                    <div class="row">

                        <div style="background-color: black;" class="px-3 card col-12 col-md-4" v-for="favorite in favorites" :key="favorite.id">
                            <a class="card-link" :href="'/product/' + favorite.id"><img class="img-fluid card-img-top" :src="favorite.photo?'/'+favorite.photo:'/img/default.png'"></a>
                            <div class="card-body">
                                <h4 class="text-center p-2 card-title"><a class="text-white card-link" :href="'/product/' + favorite.id">{{favorite.title}}</a></h4>
                                <p class="text-white card-text">
                                    <span class="font-weight-bold" style="color: #e16729">{{favorite.weight}}</span> - <span class="text-lowercase" v-for="component in favorite.components" :key="component.id">{{component.title}}, </span> 
                                </p>
                            </div>
                            <div class="card-footer">
                                <div>
                                    <b-button class="text-uppercase font-weight-bold w-100" style="border-radius: 20px; background: #e16729; border-color: #e16729;" @click="addToCart(favorite.id)">В корзину</b-button>
                                </div>
                                <div class="p-2">
                                    <h5 class="text-white text-center card-text font-weight-bold" style="color: #e16729">{{favorite.price}} грн.</h5>                                
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
        'user',
        'route',
        'orders',
        'favorites'
    ],
    data() {
        return {
            errors: {},
            success: false,
            loaded: true,
            fields: {...this.user},
            old_datas: {},
            uploadedImageData: null,
        }
    },
    created(){
        this.fields.avatar = null;
        this.fields.userName = this.user.name;
        this.fields.userPhone = this.user.phone;

        this.fields.userStreet = this.user.street;
        this.fields.userBuilding = this.user.building;
        this.fields.userEntrance = this.user.entrance;
        this.fields.userHouse = this.user.house;
        this.fields.userApartment = this.user.apartment;
        this.fields.userFloor = this.user.floor;

        this.old_datas.name = this.user.name;
        this.old_datas.avatar = this.user.avatar;
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                let formData = new FormData();
                formData.set('userName', this.fields.userName == null?"":this.fields.userName);
                formData.set('email', this.fields.email == null?"":this.fields.email);
                formData.set('userPhone', this.fields.userPhone == null?"":this.fields.userPhone);
                formData.set('gender', this.fields.gender == null?"":this.fields.gender);

                formData.set('userStreet', this.fields.userStreet == null?"":this.fields.userStreet);
                formData.set('userBuilding', this.fields.userBuilding == null?"":this.fields.userBuilding);
                formData.set('userEntrance', this.fields.userEntrance == null?"":this.fields.userEntrance);
                formData.set('userHouse', this.fields.userHouse == null?"":this.fields.userHouse);
                formData.set('userApartment', this.fields.userApartment == null?"":this.fields.userApartment);
                formData.set('userFloor', this.fields.userFloor == null?"":this.fields.userFloor);

                formData.append('avatar', this.fields.avatar == null?"":this.fields.avatar);
                formData.set('current_password', this.fields.current_password == null?"":this.fields.current_password);
                formData.set('password', this.fields.password == null?"":this.fields.password);
                formData.set('password_confirmation', this.fields.password_confirmation == null?"":this.fields.password_confirmation);

                axios.post(this.route, formData, {'Content-Type': 'multipart/form-data'}).then(response => {
                    this.loaded = true;
                    this.success = true;
                    this.old_datas.name = this.fields.name;
                    this.old_datas.avatar = response.data.newAvatar;
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },

        previewImage: function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.uploadedImageData = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        },

        resetImage() {
            this.uploadedImageData = null;
            this.fields.avatar = null;
            this.$refs.fileinput.reset();
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
    }
}
</script>