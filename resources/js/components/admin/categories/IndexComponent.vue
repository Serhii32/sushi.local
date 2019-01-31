<template>
    <div>
        <b-button variant="success" class="text-uppercase font-weight-bold my-2 w-100" @click="showCreateModal()">Додати категорію</b-button>
        <div class="row">
            <div class="col-12 col-md-4 mb-4" v-for="category in categories.data" :key="category.id">
                <b-card bg-variant="light" border-variant="light" class="shadow h-100" align="center" :img-src="category.photo?'/'+category.photo:'/img/default.png'" :img-alt="category.title" img-top>
                    <h3 class="text-uppercase font-weight-bold">{{category.title}}</h3>
                    <div slot="footer">
                        <b-button variant="warning" class="text-uppercase font-weight-bold my-2 w-100" :href="'/admin/categories/' + category.id + '/edit'">Редагувати</b-button>
                        <b-button variant="danger" class="text-uppercase font-weight-bold my-2 w-100" @click="deleteCategory(category.id)">Видалити</b-button>
                    </div>
                </b-card>
            </div>
        </div>
        <b-pagination v-show="loaded && categories.from != categories.last_page" size="lg" align="center" v-model="currentPage" :total-rows="categories.total" :per-page="categories.per_page" @input="getCategories(currentPage)"></b-pagination>

        <b-modal centered lazy hide-footer size="lg" title="Додати категорію" ref="createModal">

            <form @submit.prevent="submit" class="py-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="text-center">
                                <div v-if="uploadedImageData">
                                    <b-img thumbnail fluid :src="uploadedImageData" alt="Завантажене фото" />
                                </div>
                                <div v-else>
                                    <b-img thumbnail fluid src="/img/default.png" alt="Фото відсутнє" />
                                </div>
                            </div>
                            <div class="py-4">
                                <b-form-group label-class="text-uppercase font-weight-bold" breakpoint="md" description="Виберіть фото категорії" label="Фото:" label-for="photo">
                                    <b-form-file v-model="fields.photo" :state="Boolean(errors.photo)?false:null" placeholder="Фото" @change="previewImage" accept="image/*" ref="fileinput"></b-form-file>
                                    <div v-if="errors && errors.photo">
                                        <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.photo[0] }}</b-alert>
                                    </div>
                                </b-form-group>
                                <a class="btn btn-warning w-100 text-uppercase font-weight-bold my-2" @click="resetImage">Зкинути зображення</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть назву категорії" label="Назва:" label-for="title">
                                <b-form-input id="title" name="title" :state="Boolean(errors && errors.title && errors.title[0])?false:null" type="text" placeholder="Назва" v-model="fields.title"></b-form-input>
                                <div v-if="errors && errors.title">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.title[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть SEO заголовок категорії" label="SEO заголовок:" label-for="titleSEO">
                                <b-form-input id="titleSEO" name="titleSEO" :state="Boolean(errors && errors.titleSEO && errors.titleSEO[0])?false:null" type="text" placeholder="SEO заголовок" v-model="fields.titleSEO"></b-form-input>
                                <div v-if="errors && errors.titleSEO">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.titleSEO[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть SEO описання категорії" label="SEO описання:" label-for="descriptionSEO">
                                <b-form-textarea id="descriptionSEO" name="descriptionSEO" :state="Boolean(errors && errors.descriptionSEO && errors.descriptionSEO[0])?false:null" placeholder="SEO описання" v-model="fields.descriptionSEO"></b-form-textarea>
                                <div v-if="errors && errors.descriptionSEO">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.descriptionSEO[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть SEO ключові слова категорії" label="SEO ключові слова:" label-for="keywordsSEO">
                                <b-form-input id="keywordsSEO" name="keywordsSEO" :state="Boolean(errors && errors.keywordsSEO && errors.keywordsSEO[0])?false:null" type="text" placeholder="SEO ключові слова" v-model="fields.keywordsSEO"></b-form-input>
                                <div v-if="errors && errors.keywordsSEO">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.keywordsSEO[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group>
                                <b-button type="submit" class="btn btn-success w-100 text-uppercase font-weight-bold">Зберегти</b-button>
                            </b-form-group>
                        </div>
                    </div>
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
            errors: {},
            categories: {},
            currentPage: 1,
            loaded: true,
            fields: {},
            uploadedImageData: null,
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories(page) {
            if (this.loaded) {
                this.loaded = false;
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/admin/categories/getCategories?page=' + page).then(response => {
                    this.loaded = true;
                    this.categories = response.data;
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
        showCreateModal () {
            this.$refs.createModal.show();
        },
        hideCreateModal () {
            this.$refs.createModal.hide();
        },
        deleteCategory (id) {
            if (this.loaded) {
                this.loaded = false;

                axios.delete('/admin/categories/'+id).then(() => {
                    this.loaded = true;
                    this.getCategories(this.categories.current_page);
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
                let formData = new FormData();
                formData.set('title', this.fields.title == null?"":this.fields.title);
                formData.set('titleSEO', this.fields.titleSEO == null?"":this.fields.titleSEO);
                formData.set('descriptionSEO', this.fields.descriptionSEO == null?"":this.fields.descriptionSEO);
                formData.set('keywordsSEO', this.fields.keywordsSEO == null?"":this.fields.keywordsSEO);
                formData.append('photo', this.fields.photo == null?"":this.fields.photo);
                axios.post('/admin/categories', formData, {'Content-Type': 'multipart/form-data'}).then(response => {
                    this.loaded = true;
                    this.hideCreateModal();
                    this.resetImage();
                    this.fields = {};
                    this.getCategories(this.categories.last_page);
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
            this.fields.photo = null;
            this.$refs.fileinput.reset();
        }
    }
}
</script>