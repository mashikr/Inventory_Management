<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="h2">Sell List</div>
             <div class="form-group" style="{width: 300px}">
                <input type="text" name="searchEm" class="form-control" placeholder="Search" v-model="searchItem" required>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Customer</th>
                    <th scope="col">Products</th>
                    <th scope="col">Payments</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sell in filterSearch" :key="sell.id">
                    <td>
                        <span>{{ sell.customer_name }}</span>
                        <span>{{ sell.customer_address }}</span>
                    </td>
                    <td>
                        <span v-for="item,i in sell.products" :key="i">
                            {{item.name}} - {{item.quantity}}
                        </span>
                    </td>
                    <td>
                        <span>Total Quantity: {{ sell.payments.total_quantity }}</span>
                        <span>Total: {{ sell.payments.total }}</span>
                    </td>
                    <td>{{ sell.date }}</td>
                    <td>
                        <router-link class="btn btn-sm btn-primary" :to="{name: 'sellPrint', params: {id: sell.id}}" target="_blank">Print</router-link>
                        <a @click="deleteSell(sell.id)" class="btn btn-sm btn-danger">Delete</a>
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
            axios.get("/api/sell")
                .then(res => {
                    this.sells = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        }
        
    },
    data() {
        return {
            sells:[],
            errorMessage: '',
            searchItem: ''
        }
    },
    computed: {
        filterSearch() {
            return this.sells.filter(sell => {
                return sell.customer_name.toLowerCase().match(this.searchItem.toLowerCase());
            });
        }
    },
    methods: {
        deleteSell(id) {
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
                    axios.delete("/api/sell/"+ id)
                    .then(res => {
                         Swal.fire(
                            'Deleted!',
                            'Sell has been deleted.',
                            'success'
                        )
                        this.sells = this.sells.filter(sell => {
                            return sell.id != id;
                        });

                    })
                    .catch(err => Notification.error(err.response.data.message))
                }
                })
        }
    }
}
</script>

<style scoped>
span {
    margin-bottom: 0.30rem !important;
    display: block !important;
}
</style>