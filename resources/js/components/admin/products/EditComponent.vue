<template>
    <form @submit.prevent="submit" class="py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="text-center">
                        <div v-if="uploadedImageData">
                            <b-img thumbnail fluid :src="uploadedImageData" :alt="old_datas.title" />
                        </div>
                        <div v-else-if="old_datas.photo">
                            <b-img thumbnail fluid :src="'/'+old_datas.photo" :alt="old_datas.title" />
                        </div>
                        <div v-else>
                            <b-img thumbnail fluid src="/img/default.png" :alt="old_datas.title" />
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
                    <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть назву категорії" label="Назва:" label-for="title">
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
                    <div v-if="success">
                        <b-alert class="text-center" variant="success" dismissible fade :show="true">Дані успішно оновлено</b-alert>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!loaded" style="height: 100%; width: 100%; position: fixed; z-index: 1; top: 0; background-color: rgba(0, 0, 0, 0.2); left: 0;">
            <img style="position: relative; top: 30%; left: 50%; transform: translateX(-50%);" src="/gif/sushi.gif" alt="Завантаження">
        </div>
    </form>
</template>

<script>
export default {
    props: [
        'product',
    ],
    data() {
        return {
            errors: {},
            success: false,
            loaded: true,
            fields: {...this.product},
            old_datas: {},
            uploadedImageData: null,
            categories: {},
            components: {},
            attributes: {},
            categoriesOptions: [],
            attributesOptions: [],
            componentsOptions: [],
        }
    },
    created(){
        this.fields.photo = null;
        this.old_datas.title = this.product.title;
        this.old_datas.photo = this.product.photo;
        this.fields.attributes = [];
        this.fields.components = [];
        this.getProductDependencies();
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
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
                formData.append('photo', this.fields.photo == null?"":this.fields.photo);
                axios.post('/admin/products/'+this.product.id, formData, {'Content-Type': 'multipart/form-data'}).then(response => {
                    this.loaded = true;
                    this.success = true;
                    this.old_datas.name = this.fields.name;
                    this.old_datas.photo = response.data.newPhoto;
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },

        getProductDependencies() {
            if (this.loaded) {
                this.loaded = false;
                axios.get('/admin/products/getProductDependencies/' + this.product.id).then(response => {
                    this.loaded = true;
                    this.categories = response.data.categories;
                    this.attributes = response.data.attributes;
                    this.components = response.data.components;
                    if(response.data.productAttributes.length > 0) {
                        for (let attributeKey in response.data.productAttributes) {
                            this.fields.attributes.push(response.data.productAttributes[attributeKey].id);
                        }
                    }
                    if(response.data.productComponents.length > 0) {
                        for (let componentKey in response.data.productComponents) {
                            this.fields.components.push(response.data.productComponents[componentKey].id);
                        }
                    }
                    if(typeof this.categories.length === 'undefined') {
                        for (let prop in this.categories) {
                            this.categoriesOptions.push({text: this.categories[prop], value: Number(prop)});
                        }
                    }
                    if(typeof this.attributes.length === 'undefined') {
                        for (let prop in this.attributes) {
                            this.attributesOptions.push({text: this.attributes[prop], value: Number(prop)});
                        }
                    }
                    if(typeof this.components.length === 'undefined') {
                        for (let prop in this.components) {
                            this.componentsOptions.push({text: this.components[prop], value: Number(prop)});
                        }
                    }
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
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