<template>
    <div class="text-center">
        <span :class="[!userAgent ? 'font-bold text-indigo-900' : '']">積み上げアプリへようこそ</span>

        <div v-if="!userAgent" class="mt-10 flex justify-center">
            <Nav  :spTopNav="false" />
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