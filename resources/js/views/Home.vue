<template>
    <div class="">
        積み上げアプリへようこそ

        <div v-if="!userAgent" class="mt-10">
            <Nav />
        </div>
    </div>
</template>

<script>
import Nav from '../components/Nav';
import { mapGetters } from 'vuex';

export default {
    name: "Home",

    computed: {
        ...mapGetters({
            userAgent: 'userAgent'
        })
    },

    components: {
        Nav
    },

}
</script>