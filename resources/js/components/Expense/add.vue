<template>
    <div class="row px-lg-5 mx-lg-4">
        <div class="card mt-3 shadow">
            <div class="card-header text-center">
                <h3>Add Expense</h3>
            </div>
            <div class="card-body">
                <form enctype='multipart/form-data' @submit.prevent="addExpense">
                    <div class="form-group">
                        <label for="details">Details</label>
                        <textarea name="details" id="details" class="form-control" v-model="form.details"  rows="5" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" min="1" name="amount" class="form-control" v-model="form.amount" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Pay date</label>
                                <input type="date" name="date" class="form-control" v-model="form.date" required>
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
        },
        data() {
            return {
                form: {
                   details: null,
                   amount: null,
                   date: null
                },
            }
        },
        methods: {
            addExpense() {
               axios.post('/api/expense', this.form)
               .then((response) => {
                   this.$router.push({ name: 'allExpense'});
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