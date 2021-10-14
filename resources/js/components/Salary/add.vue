<template>
    <div class="row px-lg-5 mx-lg-4">
        <div class="card mt-3 shadow">
            <div class="card-header text-center">
                <h3>Pay Salary</h3>
            </div>
            <div class="card-body">
                <form enctype='multipart/form-data' @submit.prevent="addSalary">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Employee Name</label>
                                <select v-model="form.employee_id" class="form-select">
                                    <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{ employee.name }}</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h6>Employee Address: {{ employee_address }}</h6>
                        <h6>Employee Salary: {{ employee.salary }}</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Payment Month</label>
                                <select v-model="form.month" class="form-select">
                                    <option v-for="(month,i) in months" :key="i" :value="month">{{ month }}</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                </form>

            </div>
        </div>
    </div>
</template>


<script>
    export default {
         created() {
            if(!User.loggedIn()) {
                this.$router.push({name: '/'});
            }
            axios.get("/api/employee/all")
            .then(res => {
                this.employees = res.data;
                this.form.employee_id = this.employees[0].id;
            })
            .catch(error => this.errorMessage = error.response.data.message)
        },
        data() {
            return {
                form: {
                   employee_id: null,
                   month:  'January',
                },
                employees: {},
                employee: {},
                months: [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'
                    ],
            }
        },
        computed: {
            employee_address() {
                this.employee = this.employees.find(employee => {
                    return employee.id==this.form.employee_id;
                });
                return this.employee.address; 
            }
        },
        methods: {
            addSalary() {
               axios.post('/api/salary', this.form)
               .then((response) => {
                   if(response.data.status == 'error') {
                        Notification.error(response.data.message);
                   } else {
                       this.$router.push({ name: 'allSalary'});
                       Notification.success();
                   }
               })
               .catch(error => {
                   Notification.error(error.response.data.message);
                   this.errors = error.response.data.errors;
               })
            }
        }
    }
</script>