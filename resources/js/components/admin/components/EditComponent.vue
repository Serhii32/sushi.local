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
                        <b-form-group label-class="text-uppercase font-weight-bold" breakpoint="md" description="Виберіть фото компонента" label="Фото:" label-for="photo">
                            <b-form-file v-model="fields.photo" :state="Boolean(errors.photo)?false:null" placeholder="Фото" @change="previewImage" accept="image/*" ref="fileinput"></b-form-file>
                            <div v-if="errors && errors.photo">
                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.photo[0] }}</b-alert>
                            </div>
                        </b-form-group>
                        <a class="btn btn-warning w-100 text-uppercase font-weight-bold my-2" @click="resetImage">Зкинути зображення</a>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть назву компонента" label="Назва:" label-for="title">
                        <b-form-input id="title" name="title" :state="Boolean(errors && errors.title && errors.title[0])?false:null" type="text" placeholder="Назва" v-model="fields.title"></b-form-input>
                        <div v-if="errors && errors.title">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.title[0] }}</b-alert>
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
        'component',
    ],
    data() {
        return {
            errors: {},
            success: false,
            loaded: true,
            fields: {...this.component},
            old_datas: {},
            uploadedImageData: null,
        }
    },
    created(){
        this.fields.photo = null;
        this.old_datas.title = this.component.title;
        this.old_datas.photo = this.component.photo;
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                let formData = new FormData();
                formData.set('title', this.fields.title == null?"":this.fields.title);
                formData.append('photo', this.fields.photo == null?"":this.fields.photo);

                axios.post('/admin/components/'+this.component.id, formData, {'Content-Type': 'multipart/form-data'}).then(response => {
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