<template>
    <div>
        <b-button variant="success" class="text-uppercase font-weight-bold my-2 w-100" @click="showCreateModal()">Додати продукт</b-button>
        <div class="row">
            <div class="col-12 col-md-4 mb-4" v-for="product in products.data" :key="product.id">
                <b-card bg-variant="light" border-variant="light" class="shadow h-100" align="center" :img-src="product.photo?'/'+product.photo:'/img/default.png'" :img-alt="product.title" img-top>
                    <h3 class="text-uppercase font-weight-bold">{{product.title}}</h3>
                    <div slot="footer">
                        <b-button variant="warning" class="text-uppercase font-weight-bold my-2 w-100" :href="'/admin/products/' + product.id + '/edit'">Редагувати</b-button>
                        <b-button variant="danger" class="text-uppercase font-weight-bold my-2 w-100" @click="deleteProduct(product.id)">Видалити</b-button>
                    </div>
                </b-card>
            </div>
        </div>
        <b-pagination v-show="loaded && products.from && products.from != products.last_page" size="lg" align="center" v-model="currentPage" :total-rows="products.total" :per-page="products.per_page" @input="getProducts(currentPage)"></b-pagination>

        <b-modal centered lazy hide-footer size="lg" title="Додати продукт" ref="createModal">

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
                                <b-form-group label-class="text-uppercase font-weight-bold" breakpoint="md" description="Виберіть фото продукта" label="Фото:" label-for="photo">
                                    <b-form-file v-model="fields.photo" :state="Boolean(errors.photo)?false:null" placeholder="Фото" @change="previewImage" accept="image/*" ref="fileinput"></b-form-file>
                                    <div v-if="errors && errors.photo">
                                        <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.photo[0] }}</b-alert>
                                    </div>
                                </b-form-group>
                                <a class="btn btn-warning w-100 text-uppercase font-weight-bold my-2" @click="resetImage">Зкинути зображення</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть назву продукта" label="Назва:" label-for="title">
                                <b-form-input id="title" name="title" :state="Boolean(errors && errors.title && errors.title[0])?false:null" type="text" placeholder="Назва" v-model="fields.title"></b-form-input>
                                <div v-if="errors && errors.title">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.title[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть ціну продукта" label="Ціна:" label-for="price">
                                <b-form-input id="price" name="price" :state="Boolean(errors && errors.price && errors.price[0])?false:null" type="number" placeholder="Ціна" v-model="fields.price" step='0.01'></b-form-input>
                                <div v-if="errors && errors.price">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.price[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть вагу продукта" label="Вага:" label-for="weight">
                                <b-form-input id="weight" name="weight" :state="Boolean(errors && errors.weight && errors.weight[0])?false:null" type="text" placeholder="Вага" v-model="fields.weight"></b-form-input>
                                <div v-if="errors && errors.weight">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.weight[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Виберіть категорію продукта" label="Категорія:" label-for="category">
                                <b-form-select id="category" name="category" :state="Boolean(errors && errors.category && errors.category[0])?false:null" placeholder="Категорія" v-model="fields.category" :options="categoriesOptions"></b-form-select>
                                <div v-if="errors && errors.category">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.category[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Виберіть атрибути продукта" label="Атрибути:" label-for="attributes">
                                <b-form-select multiple id="attributes" name="attributes" :state="Boolean(errors && errors.attributes && errors.attributes[0])?false:null" placeholder="Атрибути" v-model="fields.attributes" :options="attributesOptions"></b-form-select>
                                <div v-if="errors && errors.attributes">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.attributes[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Виберіть компоненти продукта" label="Компоненти:" label-for="components">
                                <b-form-select multiple id="components" name="components" :state="Boolean(errors && errors.components && errors.components[0])?false:null" placeholder="Компоненти" v-model="fields.components" :options="componentsOptions"></b-form-select>
                                <div v-if="errors && errors.components">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.components[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть SEO заголовок продукта" label="SEO заголовок:" label-for="titleSEO">
                                <b-form-input id="titleSEO" name="titleSEO" :state="Boolean(errors && errors.titleSEO && errors.titleSEO[0])?false:null" type="text" placeholder="SEO заголовок" v-model="fields.titleSEO"></b-form-input>
                                <div v-if="errors && errors.titleSEO">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.titleSEO[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть SEO описання продукта" label="SEO описання:" label-for="descriptionSEO">
                                <b-form-textarea id="descriptionSEO" name="descriptionSEO" :state="Boolean(errors && errors.descriptionSEO && errors.descriptionSEO[0])?false:null" placeholder="SEO описання" v-model="fields.descriptionSEO"></b-form-textarea>
                                <div v-if="errors && errors.descriptionSEO">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.descriptionSEO[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть SEO ключові слова продукта" label="SEO ключові слова:" label-for="keywordsSEO">
                                <b-form-input id="keywordsSEO" name="keywordsSEO" :state="Boolean(errors && errors.keywordsSEO && errors.keywordsSEO[0])?false:null" type="text" placeholder="SEO ключові слова" v-model="fields.keywordsSEO"></b-form-input>
                                <div v-if="errors && errors.keywordsSEO">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.keywordsSEO[0] }}</b-alert>
                                </div>
                            </b-form-group>
                            <b-form-group label-class="text-uppercase font-weight-bold" description="Чи розповсюджуються знижки на продукт" label="Знижка:" label-for="isDiscount">
                                <b-form-radio-group id="isDiscount" name="isDiscount" buttons button-variant="outline-secondary" class="d-flex" v-model="fields.isDiscount" stacked :options="[{ text: 'Так', value: '1' },{ text: 'Ні', value: '0' }]" />
                                <div v-if="errors && errors.isDiscount">
                                    <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.isDiscount[0] }}</b-alert>
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
            products: {},
            categories: {},
            categoriesOptions: [],
            attributesOptions: [],
            componentsOptions: [],
            attributes: {},
            components: {},
            currentPage: 1,
            loaded: true,
            fields: {
                'attributes': [],
                'components': [],
            },
            uploadedImageData: null,
        }
    },
    created() {
        this.getProducts();
    },
    methods: {
        getProducts(page) {
            if (this.loaded) {
                this.loaded = false;
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.currentPage = page;
                axios.get('/admin/products/getProducts?page=' + page).then(response => {
                    this.loaded = true;
                    this.products = response.data.products;
                    this.categories = response.data.categories;
                    this.attributes = response.data.attributes;
                    this.components = response.data.components;
                    if(typeof this.categories.length === 'undefined') {
                        this.categoriesOptions.push({text: 'Категорія не обрана' , value: 0});
                        for (let prop in this.categories) {
                            this.categoriesOptions.push({text: this.categories[prop], value: prop});
                        }
                    }
                    if(typeof this.attributes.length === 'undefined') {
                        this.attributesOptions.push({text: 'Атрибути не обрано' , value: 0});
                        for (let prop in this.attributes) {
                            this.attributesOptions.push({text: this.attributes[prop], value: prop});
                        }
                    }
                    if(typeof this.components.length === 'undefined') {
                        this.componentsOptions.push({text: 'Компоненти не обрано' , value: 0});
                        for (let prop in this.components) {
                            this.componentsOptions.push({text: this.components[prop], value: prop});
                        }
                    }
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
        deleteProduct (id) {
            if (this.loaded) {
                this.loaded = false;

                axios.post('/admin/products/delete/'+id).then(() => {
                    this.loaded = true;
                    this.getProducts(this.products.current_page);
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
                formData.set('price', this.fields.price == null?"":this.fields.price);
                formData.set('weight', this.fields.weight == null?"":this.fields.weight);
                formData.set('category', this.fields.category == null?"":this.fields.category);
                formData.set('attributes', this.fields.attributes == null || this.fields.attributes.length == 0?"":this.fields.attributes);
                formData.set('components', this.fields.components == null || this.fields.components.length == 0?"":this.fields.components);
                formData.set('titleSEO', this.fields.titleSEO == null?"":this.fields.titleSEO);
                formData.set('descriptionSEO', this.fields.descriptionSEO == null?"":this.fields.descriptionSEO);
                formData.set('keywordsSEO', this.fields.keywordsSEO == null?"":this.fields.keywordsSEO);
                formData.set('isDiscount', this.fields.isDiscount == null?"":this.fields.isDiscount);
                formData.append('photo', this.fields.photo == null?"":this.fields.photo);
                axios.post('/admin/products', formData, {'Content-Type': 'multipart/form-data'}).then(response => {
                    this.loaded = true;
                    this.hideCreateModal();
                    this.resetImage();
                    this.fields = {
                        'attributes': [],
                        'components': [],
                    };
                    let page = this.products.last_page;
                    this.getProducts(page);
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