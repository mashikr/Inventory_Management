<template>
    <div class="row px-lg-5 mx-lg-4">
        <div class="card mt-3 shadow">
            <div class="card-header text-center">
                <h3>Add Category</h3>
            </div>
            <div class="card-body">
                <form enctype='multipart/form-data' @submit.prevent="editCategory">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" name="category" class="form-control" v-model="form.category" required>
                        <div class="text-danger" v-if="errors.category">{{ errors.category[0] }}</div>
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
            axios.get("/api/category/"+this.$route.params.id)
            .then(response => this.form = response.data)
            .catch(error => Notification.error(error.response.data.message))
        },
        data() {
            return {
                form: {
                   category: null
                },
                errors: {}
            }
        },
        methods: {
            editCategory() {
               axios.patch('/api/category/'+this.$route.params.id, this.form)
               .then((response) => {
                   this.$router.push({ name: 'allCategory'});
                   Notification.success();
               })
               .catch(error => {
                   Notification.error(error.response.data.message);
                   this.errors = error.response.data.errors;
               })
            }
        }
    }
</script>