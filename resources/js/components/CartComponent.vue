<template>
   <aside class="position-fixed p-2" style="background-color: black; border-left: 3px solid #e16729; width: 300px; min-height: 100vh; right: 0px;">
        <div v-for="item in cart" :key="item.rowId" class="container-fluid" style="border: 3px solid #e16729; border-radius: 5px;">
            <div>
                <img width=15 class="d-inline float-right" src="/img/front/icons/close.svg" @click="removeItemFromCart(item.rowId)">
            </div>
            <div class="row m-0">
                <div class="col-12 col-md-6">
                    <p class="font-weight-bold text-white m-0">{{item.name}}</p>
                    <p class="font-weight-bold text-white m-0"><img width=15 class="d-inline" src="/img/front/icons/plus.svg" @click="updateQTY(item.rowId,++item.qty)"> {{item.qty}} <img width=15 class="d-inline" src="/img/front/icons/minus.svg"@click="item.qty>1?updateQTY(item.rowId,--item.qty):item.qty"></p>
                    <p class="font-weight-bold text-white m-0">{{item.qty * item.price}} грн</p>
                </div>
                <div class="col-12 col-md-6 m-auto">
                    <img class="img-fluid" :src="'/'+item.options.photo">
                </div>
            </div>
        </div>
    </aside>
</template>
<script>
export default {
    data() {
        return {
            loaded: true,
            cart:{},
        }
    },
    created() {
        this.getCartContent();
    },
    mounted: function () { 
        this.$root.$on('cartUpdated', () => {
            this.getCartContent();
        });
    },
    methods: {
        getCartContent(){
            if (this.loaded) {
                this.loaded = false;
                axios.get('/getCartContent').then(response => {
                    this.loaded = true;
                    this.cart = response.data.cart;
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
        updateQTY(id,qty){
            if (this.loaded) {
                this.loaded = false;
                axios.post('/updateQTY', {id:id, qty:qty}).then(response => {
                    this.loaded = true;
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
        removeItemFromCart(id){
            if (this.loaded) {
                this.loaded = false;
                Vue.delete(this.cart, id);
                axios.post('/removeItemFromCart', {id:id}).then(response => {
                    this.loaded = true;
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        }
    }
}
</script>