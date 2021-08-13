<template>
    <nav :class="[userAgent ? 'pt-4' : 'bg-white']">
        <router-link to="/home" v-if="userAgent">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" class="fill-current text-blue-600 w-12 h-12"><path d="M0 0h24v24H0z" fill="none"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
        </router-link>

        <p class="pt-12 text-gray-500 text-xs uppercase font-bold" v-if="userAgent">Create</p>

        <div :class="[!userAgent ? 'border-b border-gray-400 pl-4' : '', '']">
            <button type="button" @click="getTodayPath()" class="flex items-center py-2 hover:text-blue-600 text-sm">
                <svg viewBox="0 0 24 24" class="fill-current text-blue-600 w-5 h-5"><path d="M23.3 11.9c0 .9-.6 1.4-1.4 1.4h-8.5v8.5c0 .9-.6 1.4-1.4 1.4s-1.4-.6-1.4-1.4v-8.5H2c-.9 0-1.4-.6-1.4-1.4 0-.9.6-1.4 1.4-1.4h8.5V1.9c0-.9.6-1.4 1.4-1.4s1.4.6 1.4 1.4v8.5h8.5c.9 0 1.5.6 1.5 1.5z"/></svg>
                <div class="tracking-wide pl-3">積み上げ作成・編集</div>
            </button>
        </div>

        <p class="pt-12 text-gray-500 text-xs uppercase font-bold" v-if="userAgent">General</p>

        <div :class="[!userAgent ? 'border-b border-gray-400 pl-4' : '', '']">
            <button type="button" @click="goReports()" class="flex items-center py-2 hover:text-blue-600 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" class="fill-current text-blue-600"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 20h4V4h-4v16zm-6 0h4v-8H4v8zM16 9v11h4V9h-4z"/></svg>
                <div class="tracking-wide pl-3">積み上げ集計</div>
            </button>
        </div>

        <p class="pt-12 text-gray-500 text-xs uppercase font-bold" v-if="userAgent">Settings</p>

        <div :class="[!userAgent ? 'border-b border-gray-400 pl-4' : '', '']">
            <router-link to="/logout" class="flex items-center py-2 hover:text-blue-600 text-sm">
                <svg viewBox="0 0 24 24" class="fill-current text-blue-600 w-5 h-5"><path d="M21 3h-3.8c-.7 0-1.3-.6-1.3-1.3S16.5.4 17.2.4h5.1c.7 0 1.3.6 1.3 1.3v20.5c0 .7-.6 1.3-1.3 1.3h-5.1c-.7 0-1.3-.6-1.3-1.3 0-.7.6-1.3 1.3-1.3H21V3zm-6.9 7.7L8.6 5.2c-.5-.5-.6-1.3-.1-1.8s1.3-.5 1.8 0l7.7 7.7c.8.8.2 2.2-.9 2.2H1.8c-.7 0-1.3-.6-1.3-1.3 0-.7.6-1.3 1.3-1.3h12.3zm-1.6 4.8c.5-.5 1.3-.4 1.8.1s.4 1.3-.1 1.8l-3.8 3.2c-.5.5-1.3.4-1.8-.1-.6-.5-.5-1.3 0-1.7l3.9-3.3z"/></svg>
                <div class="tracking-wide pl-3">ログアウト</div>
            </router-link>
        </div>
    </nav>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "Nav",

        mounted() {
            this.setYyyymmdd();
            this.$store.dispatch('fetchTsumiageCount');
        },

        data: function() {
            return {
                todayPath: '',
            }
        },

        computed: {
            ...mapGetters({
                authUser: 'authUser',
                yyyymmdd: 'yyyymmdd',
                tsumiageCount: 'tsumiageCount',
                userAgent: 'userAgent'
            })
        },

        methods: {
            setYyyymmdd: function () {
                let now = new Date();
                let Year = now.getFullYear();
                let Month = ("00" + (now.getMonth()+1)).slice(-2);
                let Day = ("00" + now.getDate()).slice(-2);
                let yyyymmdd = Year + Month + Day;
                let yyyy_mm_dd = Year + "-" + Month + "-" + Day;
                this.$store.dispatch('setDay', {0: yyyymmdd, 1: yyyy_mm_dd});
            },
            closeNav: function() {
                this.$emit('closeNav');
            },
            getTodayPath: function () {
                if (this.tsumiageCount > 0) {
                    var todayPath = '/tsumiage/edit/' + this.yyyymmdd;
                } else {
                    var todayPath = '/tsumiage/create/' + this.yyyymmdd;
                }

                if (this.$route.path != todayPath) {
                    this.$router.push(todayPath);
                }

                this.closeNav();
            },
            goReports: function() {
                if (this.$route.path != '/reports') {
                    this.$router.push('/reports');
                }
                this.closeNav();
            }
        }
    }
</script>

<style scoped>

</style>