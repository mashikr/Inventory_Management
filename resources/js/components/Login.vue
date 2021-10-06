<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                 <form class="form-signin text-center">
                    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" id="inputEmail" class="form-control form-control-lg" placeholder="Email address" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control form-control-lg" placeholder="Password" required>
                    <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>
