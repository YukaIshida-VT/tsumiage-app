<template>
        <img :src="authUser.data.attributes.avatar" alt="twitter avatar" class="rounded-full border border-gray-400 w-10 h-10">
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "UserCircle",

        props: [
            'name',
        ],

        computed: {
            ...mapGetters({
                authUser: 'authUser'
            })
        }
    }
</script>

<style scoped>

</style>