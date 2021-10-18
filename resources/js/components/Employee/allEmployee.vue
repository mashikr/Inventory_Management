<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="h2">Employee List</div>
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
                    <th scope="col">Salary</th>
                    <th scope="col">Joining Date</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in filterSearch" :key="employee.id">
                    <td>{{ employee.name }}</td>
                    <td><img :src="employee.photo ? employee.photo : '/employee_image/male-user.png'" alt="Employee photo"></td>
                    <td>+880{{ employee.phone }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.salary }}</td>
                    <td>{{ employee.joining_date }}</td>
                    <td>
                        <router-link :to="{name: 'editEmployee', params: {id: employee.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                        <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center" v-if="employees.length == 0">
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
            axios.get("/api/employee/all")
                .then(res => {
                    this.employees = res.data;
                })
                .catch(error => this.errorMessage = error.response.data.message)
        }
        
    },
    data() {
        return {
            employees:[],
            errorMessage: '',
            searchItem: ''
        }
    },
    computed: {
        filterSearch() {
            return this.employees.filter(employee => {
                return employee.name.toLowerCase().match(this.searchItem.toLowerCase());
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
                    axios.delete("/api/employee/delete/"+ id)
                    .then(res => {
                         Swal.fire(
                            'Deleted!',
                            'Employee data has been deleted.',
                            'success'
                        )
                        this.employees = this.employees.filter(employee => {
                            return employee.id != id;
                        });

                    })
                    .catch(err => Notification.error(err.response.data.message))
                }
                })
        }
    }
}
</script>