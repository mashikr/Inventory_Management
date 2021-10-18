<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="h2">Category List</div>
             <div class="form-group" style="{width: 300px}">
                <input type="text" name="searchEm" class="form-control" placeholder="Search" v-model="searchItem" required>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in filterSearch" :key="category.id">
                    <td>{{ category.category }}</td>
                    <td>
                        <router-link :to="{name: 'editCategory', params: {id: category.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                        <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center" v-if="categories.length == 0">
            <i class="fas fa-spinner fa-pulse fa-3x"></i>
        </div>
        <div class="h2 text-danger mt-4">{{ errorMessage }}</div>
    </div>
</template>

<script>
export default {
    created() {
        if(!User.loggedIn()) {
                this.$router.push({name: '/'});
        } else {
            axios.get("/api/category")
                .then(res => {
                    this.categories = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        }
        
    },
    data() {
        return {
            categories:[],
            errorMessage: '',
            searchItem: ''
        }
    },
    computed: {
        filterSearch() {
            return this.categories.filter(category => {
                return category.category.toLowerCase().match(this.searchItem.toLowerCase());
            });
        }
    },
    methods: {
        deleteCategory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete("/api/category/"+ id)
                    .then(res => {
                         Swal.fire(
                            'Deleted!',
                            'Category has been deleted.',
                            'success'
                        )
                        this.categories = this.categories.filter(category => {
                            return category.id != id;
                        });

                    })
                    .catch(err => Notification.error(err.response.data.message))
                }
                })
        }
    }
}
</script>