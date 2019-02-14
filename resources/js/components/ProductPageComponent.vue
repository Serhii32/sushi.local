<template>
    <section style="min-height: 100vh; background-color: black; margin-left: 60px; margin-right: 300px;">
        {{product}}
    </section>
</template>
<script>
export default {
    props: [
        'product'
    ],
    data() {
        return {
            loaded: true,
        }
    },
    methods: {
        ddToCart(id){
            if (this.loaded) {
                this.loaded = false;
    
                axios.post('/addToCart', {id:id}).then(response => {
                    this.loaded = true;

                    this.$root.$emit('cartUpdated');

                }).catch(error => {
                    this.loaded = true;
                });
            }
        }
    }
}
</script>