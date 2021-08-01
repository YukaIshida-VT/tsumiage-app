<template>
    
</template>

<script>
    export default {
        name: "Logout",

        created() {
            axios.get('/logout', {})
                .finally(err => {
                    window.location = '/auth/twitter/logout';
                })
        }
    }
</script>

<style scoped>

</style>