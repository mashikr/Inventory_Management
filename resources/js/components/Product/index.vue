<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="h2">Product List</div>
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
                    <th scope="col">Code</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Category</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Buying date</th>
                    <th scope="col">Buying Price</th>
                    <th scope="col">Selling Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in filterSearch" :key="product.id">
                    <td>{{ product.product_name }}</td>
                    <td>{{ product.product_code }}</td>
                    <td><img :src="product.image" alt="Product photo"></td>
                    <td>{{ product.category }}</td>
                    <td>{{ product.supplier }}</td>
                    <td>{{ product.buying_date }}</td>
                    <td>{{ product.buying_price }}</td>
                    <td>{{ product.selling_price }}</td>
                    <td>{{ product.product_quantity }}</td>
                    <td>
                        <router-link :to="{name: 'editProduct', params: {id: product.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                        <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                    </tr>
                </tbody>
            </table>
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
            axios.get("/api/product")
                .then(res => {
                    this.products = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        }
        
    },
    data() {
        return {
            products:[],
            errorMessage: '',
            searchItem: ''
        }
    },
    computed: {
        filterSearch() {
            return this.products.filter(product => {
                return product.product_name.toLowerCase().match(this.searchItem.toLowerCase());
            });
        }
    },
    methods: {
        deleteProduct(id) {
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
                    axios.delete("/api/product/"+ id)
                    .then(res => {
                         Swal.fire(
                            'Deleted!',
                            'Product has been deleted.',
                            'success'
                        )
                        this.products = this.products.filter(product => {
                            return product.id != id;
                        });

                    })
                    .catch(err => Notification.error(err.response.data.message))
                }
                })
        }
    }
}
</script>