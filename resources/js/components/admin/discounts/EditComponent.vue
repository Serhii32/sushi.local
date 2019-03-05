<template>
    <form @submit.prevent="submit" class="py-4">
        <div class="container-fluid">
            <div class="col-12 col-md-6">
                <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть назву знижки" label="Назва:" label-for="title">
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
        <div v-if="!loaded" style="height: 100%; width: 100%; position: fixed; z-index: 1; top: 0; background-color: rgba(0, 0, 0, 0.2); left: 0;">
            <img style="position: relative; top: 30%; left: 50%; transform: translateX(-50%);" src="/gif/sushi.gif" alt="Завантаження">
        </div>
    </form>
</template>

<script>
export default {
    props: [
        'discount',
    ],
    data() {
        return {
            errors: {},
            success: false,
            loaded: true,
            fields: {...this.component},
        }
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                let formData = new FormData();
                formData.set('title', this.fields.title == null?"":this.fields.title);

                axios.post('/admin/discounts/'+this.discount.id, formData).then(response => {
                    this.loaded = true;
                    this.success = true;
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        }
    }
}
</script>