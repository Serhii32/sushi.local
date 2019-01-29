<template>
    <div>
        <div class="row">
            <div class="col-12 col-md-4 mb-4" v-for="category in categories.data" :key="category.id">
                <b-card bg-variant="light" border-variant="light" class="shadow" align="center" :img-src="category.photo?'/'+category.photo:'/img/default.png'" :img-alt="category.title" img-top>
                    <h3 class="text-uppercase font-weight-bold">{{category.title}}</h3>
                    <div slot="footer">
                        <b-button variant="warning" class="text-uppercase font-weight-bold my-2 w-100" @click="showEditModal(category)">Редагувати</b-button>
                        <b-button variant="danger" class="text-uppercase font-weight-bold my-2 w-100">Видалити</b-button>
                    </div>
                </b-card>
            </div>
        </div>
        <b-pagination v-show="loaded" size="lg" align="center" v-model="currentPage" :total-rows="categories.total" :per-page="categories.per_page" @input="getCategories(currentPage)"></b-pagination>

        <b-modal centered lazy hide-footer size="lg" :title="'Редагувати ' + fields.title" ref="editModal">

            <form @submit.prevent="submit" class="py-4">
                <div class="container-fluid">
                    <h3>csdacsaca asdcsccsca csa sacsa csac sa csacascscs ac ac cs sa csdacsaca asdcsccsca csa sacsa csac sa csacascscs ac ac cs sacsdacsaca asdcsccsca csa sacsa csac sa csacascscs ac ac cs</h3>
                  <!--   <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="text-center">
                                <div v-if="uploadedImageData">
                                    <img class="img-thumbnail img-fluid" :src="uploadedImageData" :alt="old_datas.name">
                                </div>
                                <div v-else-if="old_datas.avatar">
                                    <img class="img-thumbnail img-fluid" :src="'/'+old_datas.avatar" :alt="old_datas.name">
                                </div>
                                <div v-else>
                                    <img class="img-thumbnail img-fluid" src="/img/avatars/default.png" :alt="old_datas.name">
                                </div>
                            </div>


                            <div class="form-group py-4">
                                <label for="avatar" class="text-uppercase font-weight-bold">Вибрати фото адміністратора:</label>
                                <b-form-file v-model="fields.avatar" :state="Boolean(errors.avatar)?!Boolean(errors.avatar):null" placeholder="Фото" @change="previewImage" accept="image/*" ref="fileinput"></b-form-file>
                                <div v-if="errors && errors.avatar">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.avatar[0] }}</b-alert>
                                </div>
                                <a class="btn btn-warning w-100 text-uppercase font-weight-bold my-2" @click="resetImage">Зкинути зображення</a>
                            </div>


                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-uppercase font-weight-bold">Ім'я:</label>
                                <input id="name" type="text" name="name" placeholder="Ім'я" class="form-control" v-model="fields.name" v-bind:class="{ 'is-invalid': errors && errors.name && errors.name[0] }">
                                <div v-if="errors && errors.name">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.name[0] }}</b-alert>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="text-uppercase font-weight-bold">Email:</label>
                                <input id="email" type="email" name="email" placeholder="Email" class="form-control" v-model="fields.email" v-bind:class="{ 'is-invalid': errors && errors.email && errors.email[0] }">
                                <div v-if="errors && errors.email">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.email[0] }}</b-alert>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="text-uppercase font-weight-bold">Телефон:</label>
                                <input id="phone" type="number" name="phone" placeholder="Телефон" class="form-control" v-model="fields.phone" v-bind:class="{ 'is-invalid': errors && errors.phone && errors.phone[0] }">
                                <div v-if="errors && errors.phone">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.phone[0] }}</b-alert>
                                </div>
                            </div>
                            <div class="form-group">
                                <b-form-group class="text-uppercase font-weight-bold" label="Стать:">
                                    <b-form-radio-group buttons button-variant="outline-secondary" class="d-flex" v-model="fields.gender" stacked :options="[{ text: 'Чоловіча', value: '1' },{ text: 'Жіноча', value: '0' }]" />
                                </b-form-group>
                                <div v-if="errors && errors.gender">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.gender[0] }}</b-alert>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="current_password" class="text-uppercase font-weight-bold">Поточний пароль:</label>
                                <input id="current_password" type="password" name="current_password" placeholder="Поточний пароль" class="form-control" v-model="fields.current_password" v-bind:class="{ 'is-invalid': errors && errors.current_password && errors.current_password[0] }">
                                <div v-if="errors && errors.current_password">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.current_password[0] }}</b-alert>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-uppercase font-weight-bold">Новий пароль:</label>
                                <input id="password" type="password" name="password" placeholder="Новий пароль" class="form-control" v-model="fields.password" v-bind:class="{ 'is-invalid': errors && errors.password && errors.password[0] }">
                                <div v-if="errors && errors.password">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.password[0] }}</b-alert>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="text-uppercase font-weight-bold">Підтвердити пароль:</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Підтвердити пароль" class="form-control" v-model="fields.password_confirmation" v-bind:class="{ 'is-invalid': errors && errors.password && errors.password[0] }">
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
                    </div> -->
                </div>
            </form>
        </b-modal>
        <div v-if="!loaded" style="height: 100%; width: 100%; position: fixed; z-index: 1; top: 0; background-color: rgba(0, 0, 0, 0.2); left: 0;">
            <img style="position: relative; top: 30%; left: 50%; transform: translateX(-50%);" src="/gif/sushi.gif" alt="Завантаження">
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            categories: {},
            currentPage: 1,
            // success: false,
            loaded: true,
            fields: {}
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories(page) {
            if (this.loaded) {
                this.loaded = false;
                // this.success = false;
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/admin/categories/getCategories?page=' + page).then(response => {
                    this.loaded = true;
                    // this.success = true;
                    this.categories = response.data;
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
        showEditModal (item) {
            this.$refs.editModal.show();
            this.fields = item;
        },
    }
}
</script>