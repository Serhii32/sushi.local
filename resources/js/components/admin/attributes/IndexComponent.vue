<template>
    <div>
        <b-button variant="success" class="text-uppercase font-weight-bold my-2 w-100" @click="showCreateModal()">Додати атрибут</b-button>
        <div class="row">
            <div class="col-12 col-md-4 mb-4" v-for="attribute in attributes.data" :key="attribute.id">
                <b-card bg-variant="light" border-variant="light" class="shadow h-100" align="center">
                    <h3 class="text-uppercase font-weight-bold">{{attribute.title}}</h3>
                    <div slot="footer">
                        <b-button variant="warning" class="text-uppercase font-weight-bold my-2 w-100" :href="'/admin/attributes/' + attribute.id + '/edit'">Редагувати</b-button>
                        <b-button variant="danger" class="text-uppercase font-weight-bold my-2 w-100" @click="deleteAttribute(attribute.id)">Видалити</b-button>
                    </div>
                </b-card>
            </div>
        </div>
        <b-pagination v-show="loaded && attributes.from && attributes.from != attributes.last_page" size="lg" align="center" v-model="currentPage" :total-rows="attributes.total" :per-page="attributes.per_page" @input="getAttributes(currentPage)"></b-pagination>

        <b-modal centered lazy hide-footer size="lg" title="Додати атрибут" ref="createModal">
            <form @submit.prevent="submit" class="py-4">
                <div class="container-fluid">
                    <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть назву атрибута" label="Назва:" label-for="title">
                        <b-form-input id="title" name="title" :state="Boolean(errors && errors.title && errors.title[0])?false:null" type="text" placeholder="Назва" v-model="fields.title"></b-form-input>
                        <div v-if="errors && errors.title">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.title[0] }}</b-alert>
                        </div>
                    </b-form-group>
                    <b-form-group label-class="text-uppercase font-weight-bold" description="Виберіть тип атрибута" label="Тип:" label-for="type">
                        <b-form-radio-group id="type" name="type" buttons button-variant="outline-secondary" class="d-flex" v-model="fields.type" stacked :options="[{ text: 'Таби', value: '1' },{ text: 'Чекбокс', value: '0' }]" />
                        <div v-if="errors && errors.type">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.type[0] }}</b-alert>
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
            attributes: {},
            currentPage: 1,
            loaded: true,
            fields: {},
        }
    },
    created() {
        this.getAttributes();
    },
    methods: {
        getAttributes(page) {
            if (this.loaded) {
                this.loaded = false;
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.currentPage = page;
                axios.get('/admin/attributes/getAttributes?page=' + page).then(response => {
                    this.loaded = true;
                    this.attributes = response.data;
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
        deleteAttribute (id) {
            if (this.loaded) {
                this.loaded = false;

                axios.post('/admin/attributes/delete/'+id).then(() => {
                    this.loaded = true;
                    this.getAttributes(this.attributes.current_page);
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
                formData.set('type', this.fields.type == null?"":this.fields.type);
                axios.post('/admin/attributes', formData, {'Content-Type': 'multipart/form-data'}).then(response => {
                    this.loaded = true;
                    this.hideCreateModal();
                    this.fields = {};
                    let page = this.attributes.last_page;
                    this.getAttributes(page);
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