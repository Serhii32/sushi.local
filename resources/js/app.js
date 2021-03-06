
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

import VueCarousel from 'vue-carousel';

Vue.use(VueCarousel);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('admin-home-edit-component', require('./components/admin/HomeEditComponent.vue').default);
Vue.component('admin-categories-index-component', require('./components/admin/categories/IndexComponent.vue').default);
Vue.component('admin-categories-edit-component', require('./components/admin/categories/EditComponent.vue').default);
Vue.component('admin-components-index-component', require('./components/admin/components/IndexComponent.vue').default);
Vue.component('admin-components-edit-component', require('./components/admin/components/EditComponent.vue').default);
Vue.component('admin-attributes-index-component', require('./components/admin/attributes/IndexComponent.vue').default);
Vue.component('admin-attributes-edit-component', require('./components/admin/attributes/EditComponent.vue').default);
Vue.component('admin-products-index-component', require('./components/admin/products/IndexComponent.vue').default);
Vue.component('admin-products-edit-component', require('./components/admin/products/EditComponent.vue').default);
Vue.component('admin-promotions-index-component', require('./components/admin/promotions/IndexComponent.vue').default);
Vue.component('admin-promotions-edit-component', require('./components/admin/promotions/EditComponent.vue').default);
Vue.component('admin-orders-index-component', require('./components/admin/orders/IndexComponent.vue').default);
Vue.component('admin-modals-index-component', require('./components/admin/modals/IndexComponent.vue').default);
Vue.component('admin-modals-edit-component', require('./components/admin/modals/EditComponent.vue').default);
Vue.component('admin-discount-index-component', require('./components/admin/discounts/IndexComponent.vue').default);
Vue.component('admin-discount-edit-component', require('./components/admin/discounts/EditComponent.vue').default);
Vue.component('admin-galleries-index-component', require('./components/admin/galleries/IndexComponent.vue').default);
Vue.component('admin-galleries-edit-component', require('./components/admin/galleries/EditComponent.vue').default);
Vue.component('user-home-component', require('./components/user/HomeComponent.vue').default);
Vue.component('cart-header-counter-component', require('./components/CartHeaderCounterComponent.vue').default);
Vue.component('index-page-component', require('./components/IndexPageComponent.vue').default);
Vue.component('category-page-component', require('./components/CategoryPageComponent.vue').default);
Vue.component('product-page-component', require('./components/ProductPageComponent.vue').default);
Vue.component('cart-component', require('./components/CartComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
