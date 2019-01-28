<template>
    <div class="row">
        <div class="col-12 col-md-4 mb-4" v-for="category in categories.data" :key="category.id">
            <b-card bg-variant="light" border-variant="light" class="shadow" align="center" :img-src="category.photo?'/'+category.photo:'/img/default.png'" :img-alt="category.title" img-top>
                <h3 class="text-uppercase font-weight-bold">{{category.title}}</h3>
                <div slot="footer">
                    <b-button variant="warning" class="text-uppercase font-weight-bold my-2 w-100">Редагувати</b-button>
                    <b-button variant="danger" class="text-uppercase font-weight-bold my-2 w-100">Видалити</b-button>
                </div>
            </b-card>
        </div>
        <pagination :data="categories" @pagination-change-page="getResults"></pagination>
    </div>
</template>
<script>
export default {
    props: [
        'initialcategories',
    ],
    data() {
        return {
            categories: {...this.initialcategories},
        }
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }

            axios.get('/api/admin/categories?page=' + page)
            .then(response => {
                console.log(response);
            }).catch(error => {
                console.log(error);
            });

            // this.$http.get('/categories?page=' + page)
            //     .then(response => {
            //         return response.json();
            //     }).then(data => {
            //         this.categories = data;
            //     });
        }
    }
}
</script>