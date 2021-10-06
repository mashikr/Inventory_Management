<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                 <form class="form-signin" @submit.prevent="login">
                    <h1 class="h3 mb-3 font-weight-normal text-center">Sign in</h1>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="form.email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" v-model="form.password" placeholder="Password" required>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            if(User.loggedIn()) {
                this.$router.push({name: 'home'});
                location.reload();
            }
        },
        data() {
            return {
                form: {
                    email: null,
                    password: null
                }
            }
        },
        methods: {
            login() {
                axios.post('/api/auth/login', this.form)
                .then(res => {
                     User.responseAfterLogin(res);

                    Toast.fire({
                        icon: 'success',
                        title: 'Signed in successfully'
                    })

                     this.$router.push({ name: 'home' })
                     location.reload();
                })
                .catch(error => this.errors = error.response.data.errors)
                .catch(
                   Toast.fire({
                        icon: 'warning',
                        title: 'Invalid Email or Password'
                    }) 
                )
            }
        }
    }
</script>
