<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="h2">Salary Payment List</div>
             <div class="form-group" style="{width: 300px}">
                <input type="text" name="searchEm" class="form-control" placeholder="Search" v-model="searchItem" required>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Salary Month</th>
                    <th scope="col">Pay date</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="salary in filterSearch" :key="salary.id">
                    <td>{{ salary.employee_name }}</td>
                    <td>{{ salary.employee_salary }}</td>
                    <td>{{ salary.month }} {{ salary.year }}</td>
                    <td>{{ salary.pay_date }}</td>
                    <td>
                        <!-- <router-link :to="{name: 'editExpense', params: {id: expense.id}}" class="btn btn-sm btn-primary">Edit</router-link> -->
                        <a @click="deleteSalary(salary.id)" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center" v-if="salaries.length == 0">
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
            axios.get("/api/salary")
                .then(res => {
                    this.salaries = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        }
        
    },
    data() {
        return {
            salaries:[],
            errorMessage: '',
            searchItem: ''
        }
    },
    computed: {
        filterSearch() {
            return this.salaries.filter(salary => {
                return salary.employee_name.toLowerCase().match(this.searchItem.toLowerCase());
            });
        }
    },
    methods: {
        deleteSalary(id) {
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
                    axios.delete("/api/salary/"+ id)
                    .then(res => {
                         Swal.fire(
                            'Deleted!',
                            'Salary has been deleted.',
                            'success'
                        )
                        this.salaries = this.salaries.filter(salary => {
                            return salary.id != id;
                        });

                    })
                    .catch(err => Notification.error(err.response.data.message))
                }
                })
        }
    }
}
</script>