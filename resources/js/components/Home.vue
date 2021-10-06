<template>
    <div>
        Home
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
                
            }
        },
    }
</script>