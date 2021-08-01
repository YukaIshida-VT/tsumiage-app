<template>
    <div class="rounded-full border border-gray-400 text-white bg-blue-400 w-10 h-10 flex justify-center items-center">
        <img :src="authUser.data.attributes.avatar" alt="">
    </div>
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