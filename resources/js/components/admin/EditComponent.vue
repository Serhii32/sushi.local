<template>
    <form @submit.prevent="submit" class="py-4" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="text-center">
                        <div v-if="old_datas.avatar">
                            <img class="img-thumbnail img-fluid" src="old_datas.avatar" alt="old_datas.name">
                        </div>
                        <div v-else>
                            <img class="img-thumbnail img-fluid" src="/img/avatars/default.png" :alt="old_datas.name">
                        </div>
                    </div>
                    <div class="form-group py-4">
                        <label for="avatar" class="text-uppercase font-weight-bold">Вибрати фото адміністратора:</label>
                        <b-form-file v-model="fields.avatar" :state="Boolean(errors.avatar)?!Boolean(errors.avatar):null" placeholder="Фото"></b-form-file>
                        <span v-if="errors && errors.avatar" class="text-danger">{{ errors.avatar[0] }}</span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name" class="text-uppercase font-weight-bold">Ім'я:</label>
                        <input id="name" type="text" name="name" placeholder="Ім'я" class="form-control" v-model="fields.name" v-bind:class="{ 'is-invalid': errors && errors.name && errors.name[0] }">
                        <span v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</span>
                    </div>
                    <div class="form-group">
                        <label for="email" class="text-uppercase font-weight-bold">Email:</label>
                        <input id="email" type="email" name="email" placeholder="Email" class="form-control" v-model="fields.email" v-bind:class="{ 'is-invalid': errors && errors.email && errors.email[0] }">
                        <span v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</span>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="text-uppercase font-weight-bold">Телефон:</label>
                        <input id="phone" type="number" name="phone" placeholder="Телефон" class="form-control" v-model="fields.phone" v-bind:class="{ 'is-invalid': errors && errors.phone && errors.phone[0] }">
                        <span v-if="errors && errors.phone" class="text-danger">{{ errors.phone[0] }}</span>
                    </div>
                    <div class="form-group">
                        <b-form-group class="text-uppercase font-weight-bold" label="Стать:">
                            <b-form-radio-group buttons button-variant="secondary" v-model="fields.gender" :options="[{ text: 'Чоловіча', value: '1' },{ text: 'Жіноча', value: '0' }]" />
                        </b-form-group>
                        <span v-if="errors && errors.gender" class="text-danger">{{ errors.gender[0] }}</span>
                    </div>
                    <div class="form-group">
                        <label for="current_password" class="text-uppercase font-weight-bold">Поточний пароль:</label>
                        <input id="current_password" type="password" name="current_password" placeholder="Поточний пароль" class="form-control" v-model="fields.current_password" v-bind:class="{ 'is-invalid': errors && errors.current_password && errors.current_password[0] }">
                        <span v-if="errors && errors.current_password" class="text-danger">{{ errors.current_password[0] }}</span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-uppercase font-weight-bold">Новий пароль:</label>
                        <input id="password" type="password" name="password" placeholder="Новий пароль" class="form-control" v-model="fields.password" v-bind:class="{ 'is-invalid': errors && errors.password && errors.password[0] }">
                        <span v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</span>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="text-uppercase font-weight-bold">Підтвердити пароль:</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Підтвердити пароль" class="form-control" v-model="fields.password_confirmation" v-bind:class="{ 'is-invalid': errors && errors.password_confirmation && errors.password_confirmation[0] }">
                        <span v-if="errors && errors.password_confirmation" class="text-danger">{{ errors.password_confirmation[0] }}</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success w-100 text-uppercase font-weight-bold">Зберегти</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-if="success" class="alert alert-success mt-3">
            Message sent!
        </div>
    </form>
</template>

<script>
export default {
    props: [
        'admin',
        'route'
    ],
    data() {
        return {
            errors: {},
            success: false,
            loaded: true,
            fields: {...this.admin},
            old_datas: {...this.admin},
        }
    },
    mounted() {
        this.update()
    },
    methods: {
        update: function() {
            console.log(this.route);
        },
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                axios.put(this.route, this.fields).then(response => {
                    this.loaded = true;
                    this.success = true;
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
                this.old_datas = {...this.fields};
            }
        },
    }
}
</script>