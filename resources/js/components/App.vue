<template>
    <div class="h-screen bg-white">
        <div :class="[userAgent ? 'flex' : '']" v-if="authUser">
            <div class="pl-6 bg-gray-200 w-48 h-screen border-r-2 border-gray-400" v-if="userAgent">
                <Nav :spTopNav="false" />
            </div>
            <div class="flex flex-col flex-1 h-screen overflow-y-hidden relative">
                <div :class="[userAgent ? 'px-6' : 'bg-gray-200 px-3', 'flex  justify-between items-center h-16 border-b border-gray-400']">
                    <div v-if="userAgent">
                        {{ title }}
                    </div>
                    <div class="py-1 text-xl" v-else>
                        <router-link to="/home">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" class="fill-current text-blue-600 w-10 h-10"><path d="M0 0h24v24H0z" fill="none"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                        </router-link>
                    </div>

                    <div class="flex items-center">
                        <div class="pr-4 text-sm">{{ authUser.data.attributes.name }}さん</div>
                        <UserCircle v-if="userAgent" />
                    </div>

                    <div v-if="!userAgent">
                        <button type="button" @click="open = !open">
                            <div v-if="open">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000" class="w-10 h-10"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
                            </div>
                            <div v-else>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000" class="w-10 h-10"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
                            </div>  
                        </button>
                    </div>
                </div>

                <div v-if="!userAgent && open" class="absolute mt-16 z-50 w-full">
                    <Nav @closeNav="close()" :spTopNav="true" />
                </div>

                <div class="flex flex-col overflow-y-hidden flex-1">
                    <router-view class="p-6 overflow-x-hidden"></router-view>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import UserCircle from './UserCircle';
    import SearchBar from '../components/SearchBar';
    import Nav from '../components/Nav';
    import { mapGetters } from 'vuex';

    export default {
        name: "App",

        props: [
            'user'
        ],

        computed: {
            ...mapGetters({
                authUser: 'authUser',
                userAgent: 'userAgent'
            })
        },

        components: {
            UserCircle,
            SearchBar,
            Nav
        },

        mounted() {
            this.$store.dispatch('fetchAuthUser');
            this.$store.dispatch('getUserAgent');
        },

        created() {
            this.title = this.$route.meta.title;

            window.axios.interceptors.request.use(
                (config) => {
                    if (config.method === 'get') {
                        config.url = config.url + '?api_token=' + this.user.api_token;
                    } else {
                        config.data = {
                            ...config.data,
                            api_token: this.user.api_token
                        };
                    }
                    return config;
                }
            )
        },

        data: function () {
            return {
                title: '',
                defaultDate: new Date(),
                open: false
            }
        },

        methods: {
            close: function() {
                this.open = false;
            }
        },

        watch: {
            $route(to, from) {
                this.title = to.meta.title;
            },

            title() {
                document.title = this.title + ' | Tsumiage App'
            }
        }
    }
</script>

<style scoped>

</style>