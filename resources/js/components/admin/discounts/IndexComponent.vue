<template>
    <div>
        <b-button variant="success" class="text-uppercase font-weight-bold my-2 w-100" @click="showCreateModal()">Додати знижку</b-button>
        <div class="row">
            <div class="col-12 col-md-4 mb-4" v-for="discount in discounts" :key="discount.id">
                <b-card bg-variant="light" border-variant="light" class="shadow h-100" align="center">
                    <h3 class="text-uppercase font-weight-bold">{{discount.title}}</h3>
                    <div slot="footer">
                        <b-button variant="warning" class="text-uppercase font-weight-bold my-2 w-100" :href="'/admin/discounts/' + discount.id + '/edit'">Редагувати</b-button>
                        <b-button variant="danger" class="text-uppercase font-weight-bold my-2 w-100" @click="deleteDiscount(discount.id)">Видалити</b-button>
                    </div>
                </b-card>
            </div>
        </div>

        <b-modal centered lazy hide-footer size="lg" title="Додати знижку" ref="createModal">

            <form @submit.prevent="submit" class="py-4">
                <div class="container-fluid">
                    
                    <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть назву знижки" label="Назва:" label-for="title">
                        <b-form-input id="title" name="title" :state="Boolean(errors && errors.title && errors.title[0])?false:null" type="text" placeholder="Назва" v-model="fields.title"></b-form-input>
                        <div v-if="errors && errors.title">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.title[0] }}</b-alert>
                        </div>
                    </b-form-group>

                    <b-form-group label-class="text-uppercase font-weight-bold" description="Введіть процент продукта" label="Процент:" label-for="percent">
                        <b-form-input id="percent" name="percent" :state="Boolean(errors && errors.percent && errors.percent[0])?false:null" type="number" placeholder="Процент" v-model="fields.percent" step='1'></b-form-input>
                        <div v-if="errors && errors.percent">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.percent[0] }}</b-alert>
                        </div>
                    </b-form-group>

                    <div class="row">
                        <b-form-group class="col-12 col-md-6" description="Виберіть дату початку дії знижки">
                            <b-form-input id="startDate" name="startDate" :state="Boolean(errors && errors.startDate && errors.startDate[0])?false:null" type="date" placeholder="Дата початку" v-model="fields.startDate"></b-form-input>
                            <div v-if="errors && errors.startDate">
                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.startDate[0] }}</b-alert>
                            </div>
                        </b-form-group>
                        <b-form-group class="col-12 col-md-6" description="Виберіть час початку дії знижки">
                            <b-form-input id="startTime" name="startTime" :state="Boolean(errors && errors.startTime && errors.startTime[0])?false:null" v-model="fields.startTime"></b-form-input>
                            <div v-if="errors && errors.startTime">
                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.startTime[0] }}</b-alert>
                            </div>
                        </b-form-group>
                        <b-form-group class="col-12 col-md-6" description="Виберіть дату закінчення дії знижки">
                            <b-form-input id="endDate" name="endDate" :state="Boolean(errors && errors.endDate && errors.endDate[0])?false:null" type="date" placeholder="Дата кінця" v-model="fields.endDate"></b-form-input>
                            <div v-if="errors && errors.endDate">
                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.endDate[0] }}</b-alert>
                            </div>
                        </b-form-group>
                        <b-form-group class="col-12 col-md-6" description="Виберіть час закінчення дії знижки">
                            <b-form-input id="endTime" name="endTime" :state="Boolean(errors && errors.endTime && errors.endTime[0])?false:null" v-model="fields.endTime"></b-form-input>
                            <div v-if="errors && errors.endTime">
                                <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.endTime[0] }}</b-alert>
                            </div>
                        </b-form-group>
                    </div>

                    <b-form-group description="Виберіть активні дні знижки" label="Активні дні:" label-for="dayOfWeek">
                        <b-form-select multiple id="dayOfWeek" name="dayOfWeek" :state="Boolean(errors && errors.dayOfWeek && errors.dayOfWeek[0])?false:null" v-model="fields.dayOfWeek" :options="dayOfWeekOptions"></b-form-select>
                        <div v-if="errors && errors.dayOfWeek">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.dayOfWeek[0] }}</b-alert>
                        </div>
                    </b-form-group>

                   <!--  <b-form-group>
                        <b-form-radio-group stacked id="dayOfWeek" :state="Boolean(errors && errors.dayOfWeek && errors.dayOfWeek[0])?false:null" v-model="fields.dayOfWeek" name="dayOfWeek">
                            <b-form-radio value=1>Понеділок</b-form-radio>
                            <b-form-radio value=2>Вівторок</b-form-radio>
                            <b-form-radio value=3>Середа</b-form-radio>
                            <b-form-radio value=4>Четвер</b-form-radio>
                            <b-form-radio value=5>П'ятниця</b-form-radio>
                            <b-form-radio value=6>Субота</b-form-radio>
                            <b-form-radio value=7>Неділя</b-form-radio>
                        </b-form-radio-group>
                        <div v-if="errors && errors.dayOfWeek">
                            <b-alert class="text-center" variant="danger" dismissible fade :show="true">{{ errors.dayOfWeek[0] }}</b-alert>
                        </div>
                    </b-form-group> -->

                    <b-form-group>
                        <b-form-checkbox id="status" name="status" :state="Boolean(errors && errors.status && errors.status[0])?false:null" v-model="fields.status" value="1" unchecked-value="0">Статус</b-form-checkbox>
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
            discounts: {},
            loaded: true,
            fields: {},
            dayOfWeekOptions: [
                { value: '0', text: 'Усі дні' },
                { value: '1', text: 'Понеділок' },
                { value: '2', text: 'Вівторок' },
                { value: '3', text: 'Середа' },
                { value: '4', text: 'Четвер' },
                { value: '5', text: 'П\'ятниця' },
                { value: '6', text: 'Субота' },
                { value: '7', text: 'Неділя' },
            ],
        }
    },
    created() {
        this.getDiscounts();
        this.fields.dayOfWeek = [];
    },
    methods: {
        getDiscounts() {
            if (this.loaded) {
                this.loaded = false;
                axios.get('/admin/discounts/getDiscounts').then(response => {
                    this.loaded = true;
                    this.discounts = response.data;
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
        deleteDiscount (id) {
            if (this.loaded) {
                this.loaded = false;

                axios.post('/admin/discounts/delete/'+id).then(() => {
                    this.loaded = true;
                    this.getDiscounts();
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
                formData.set('percent', this.fields.percent == null?"":this.fields.percent);
                formData.set('startDate', this.fields.startDate == null?"":this.fields.startDate);
                formData.set('startTime', this.fields.startTime == null?"":this.fields.startTime);
                formData.set('endDate', this.fields.endDate == null?"":this.fields.endDate);
                formData.set('endTime', this.fields.endTime == null?"":this.fields.endTime);
                formData.set('dayOfWeek', this.fields.dayOfWeek == null || this.fields.dayOfWeek.length == 0?"":this.fields.dayOfWeek);

                axios.post('/admin/discounts', formData).then(response => {
                    this.loaded = true;
                    this.hideCreateModal();
                    this.fields = {};
                    this.getDiscounts();
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