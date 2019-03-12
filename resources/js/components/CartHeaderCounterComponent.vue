<template>
   <span v-show="counter > 0" style="vertical-align: bottom; background-color: #e16729; color: white; border: 2px solid white; vertical-align: bottom; border-radius: 20px; font-size: 14px; padding: 5px 8px; margin-left: -15px;">{{counter}}</span>
</template>
<script>
export default {
    data() {
        return {
            loaded: true,
            counter: 0
        }
    },
    created() {
        this.getCartContentNumber();
    },
    mounted: function () {
        this.$root.$on('cartUpdated', () => {
            this.getCartContentNumber();
        });
        this.$root.$on('UpdatedQTY', () => {
            this.getCartContentNumber();
        });
        this.$root.$on('removedItemFromCart', () => {
            this.getCartContentNumber();
        });
    },
    methods: {
        getCartContentNumber(){
            if (this.loaded) {
                this.loaded = false;
                axios.get('/getCartContentNumber').then(response => {
                    this.loaded = true;
                    this.counter = response.data.counter;
                }).catch(error => {
                    this.loaded = true;
                    console.log(error);
                });
            }
        },
    }
}
</script>