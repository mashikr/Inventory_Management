<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="h2">Customer List</div>
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
                    <th scope="col">Address</th>
                    <th scope="col">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="customer in filterSearch" :key="customer.id">
                    <td>{{ customer.name }}</td>
                    <td>{{ customer.address }}</td>
                    <td>{{ customer.phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center" v-if="customers.length == 0">
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
            axios.get("/api/customer")
                .then(res => {
                    this.customers = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        }
        
    },
    data() {
        return {
            customers:[],
            errorMessage: '',
            searchItem: ''
        }
    },
    computed: {
        filterSearch() {
            return this.customers.filter(customer => {
                return customer.name.toLowerCase().match(this.searchItem.toLowerCase());
            });
        }
    },
}
</script>