<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="h2">Supplier List</div>
             <div class="form-group" style="{width: 300px}">
                <input type="text" name="searchEm" class="form-control" placeholder="Search" v-model="searchItem" required>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Shop</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="supplier in filterSearch" :key="supplier.id">
                    <td>{{ supplier.name }}</td>
                    <td><img :src="supplier.photo ? supplier.photo : '/supplier_image/male-user.png'" alt="Employee photo"></td>
                    <td>+880{{ supplier.phone }}</td>
                    <td>{{ supplier.email }}</td>
                    <td>{{ supplier.shopname }}</td>
                    <td>
                        <router-link :to="{name: 'editSupplier', params: {id: supplier.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                        <a @click="deleteEmployee(supplier.id)" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center" v-if="suppliers.length == 0">
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
            axios.get("/api/supplier")
                .then(res => {
                    this.suppliers = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        }
        
    },
    data() {
        return {
            suppliers:[],
            errorMessage: '',
            searchItem: ''
        }
    },
    computed: {
        filterSearch() {
            return this.suppliers.filter(supplier => {
                return supplier.name.toLowerCase().match(this.searchItem.toLowerCase());
            });
        }
    },
    methods: {
        deleteEmployee(id) {
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
                    axios.delete("/api/supplier/"+ id)
                    .then(res => {
                         Swal.fire(
                            'Deleted!',
                            'Supplier data has been deleted.',
                            'success'
                        )
                        this.suppliers = this.suppliers.filter(supplier => {
                            return supplier.id != id;
                        });

                    })
                    .catch(err => Notification.error(err.response.data.message))
                }
                })
        }
    }
}
</script>