<template>
    <div>
        <b-button variant="success" class="text-uppercase font-weight-bold my-2 w-100" @click="showCreateModal()">Додати модальне вікно</b-button>
        <div class="row">
            <div class="col-12 col-md-4 mb-4" v-for="modal in modals" :key="modal.id">
                <b-card bg-variant="light" border-variant="light" class="shadow h-100" align="center">
                    <h3 class="text-uppercase font-weight-bold">{{modal.title}}</h3>
                    <div slot="footer">
                        <b-button variant="warning" class="text-uppercase font-weight-bold my-2 w-100" :href="'/admin/modals/' + modal.id + '/edit'">Редагувати</b-button>
                        <b-button variant="danger" class="text-uppercase font-weight-bold my-2 w-100" @click="deleteModal(modal.id)">Видалити</b-button>
                    </div>
                </b-card>
            </div>
        </div>

        <b-modal centered lazy hide-footer size="lg" title="Додати модальне вікно" ref="createModal">
            <form @submit.prevent="submit" class="py-4">
                <div class="container-fluid">
                    <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть назву модального вікна" label="Назва:" label-for="title">
                        <b-form-input id="title" name="title" :state="Boolean(errors && errors.title && errors.title[0])?false:null" type="text" placeholder="Назва" v-model="fields.title"></b-form-input>
                        <div v-if="errors && errors.title">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.title[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group description="Введіть описання">
                        <b-form-textarea id="description" name="description" :state="Boolean(errors && errors.description && errors.description[0])?false:null" placeholder="Описання" v-model="fields.description" rows="3" max-rows="6"/>
                        <div v-if="errors && errors.description">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.description[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group>
                        <b-form-checkbox id="status" name="status" :state="Boolean(errors && errors.status && errors.status[0])?false:null" v-model="fields.status" value="1" unchecked-value="null">Статус</b-form-checkbox>
                        <div v-if="errors && errors.call">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.status[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group>
                        <b-button type="submit" class="btn btn-success w-100 text-uppercase font-weight-bold">Зберегти</b-button>
                    </b-form-group> 
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
            modals: {},
            loaded: true,
            fields: {},
        }
    },
    created() {
        this.getModals();
    },
    methods: {
        getModals() {
            if (this.loaded) {
                this.loaded = false;
                axios.get('/admin/modals/getModals').then(response => {
                    this.loaded = true;
                    this.modals = response.data;
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
        deleteModal (id) {
            if (this.loaded) {
                this.loaded = false;

                axios.post('/admin/modals/delete/'+id).then(() => {
                    this.loaded = true;
                    this.getModals();
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
                formData.set('status', this.fields.status == null?"":this.fields.status);
                formData.set('description', this.fields.description == null?"":this.fields.description);
                axios.post('/admin/modals', formData).then(response => {
                    this.loaded = true;
                    this.hideCreateModal();
                    this.fields = {};
                    this.getModals();
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