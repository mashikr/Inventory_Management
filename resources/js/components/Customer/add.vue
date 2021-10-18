<template>
    <div class="row px-lg-5 mx-lg-4">
        <div class="card mt-3 shadow">
            <div class="card-header text-center">
                <h3>Add Customer</h3>
            </div>
            <div class="card-body">
                <form enctype='multipart/form-data' @submit.prevent="addCustomer">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" v-model="form.name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" v-model="form.address" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" v-model="form.phone" required>
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
        },
        data() {
            return {
                form: {
                   name: null,
                   address: null,
                   phone: null,
                },
                errors: {}
            }
        },
        methods: {
            addCustomer() {
               axios.post('/api/customer', this.form)
               .then((response) => {
                   if(response.data.status=='error') {
                       Notification.error(response.data.message);
                   } else {
                        this.$router.push({ name: 'allCustomer'});
                        Notification.success();
                   }
               })
               .catch(error => {
                   Notification.error(error.response.data.message);
               })
            }
        }
    }
</script>