<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="h2">Expense List</div>
             <div class="form-group" style="{width: 300px}">
                <input type="text" name="searchEm" class="form-control" placeholder="Search" v-model="searchItem" required>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Details</th>
                    <th scope="col">amount</th>
                    <th scope="col">Pay date</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="expense in filterSearch" :key="expense.id">
                    <td>{{ expense.details }}</td>
                    <td>{{ expense.amount }}</td>
                    <td>{{ expense.date }}</td>
                    <td>
                        <!-- <router-link :to="{name: 'editExpense', params: {id: expense.id}}" class="btn btn-sm btn-primary">Edit</router-link> -->
                        <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center" v-if="expenses.length == 0">
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
            axios.get("/api/expense")
                .then(res => {
                    this.expenses = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        }
        
    },
    data() {
        return {
            expenses:[],
            errorMessage: '',
            searchItem: ''
        }
    },
    computed: {
        filterSearch() {
            return this.expenses.filter(expense => {
                return expense.details.toLowerCase().match(this.searchItem.toLowerCase());
            });
        }
    },
    methods: {
        deleteExpense(id) {
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
                    axios.delete("/api/expense/"+ id)
                    .then(res => {
                         Swal.fire(
                            'Deleted!',
                            'Expense has been deleted.',
                            'success'
                        )
                        this.expenses = this.expenses.filter(expense => {
                            return expense.id != id;
                        });

                    })
                    .catch(err => Notification.error(err.response.data.message))
                }
                })
        }
    }
}
</script>