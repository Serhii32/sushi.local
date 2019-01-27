<template>
    <div class="row">
        <div class="col-12 col-md-4" v-for="category in categories" :key="category.id">
            <b-card align="center" :title="category.title" img-src="https://picsum.photos/300/300/?image=41" :img-alt="category.title" img-top>
                <div slot="footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </b-card>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'categories',
    ],
    mounted() {
        console.log(this.categories);
    }
}
</script>