<template>
    <div class="h-screen bg-white">
        <div :class="[userAgent ? 'flex' : '']" v-if="authUser">
            <div class="pl-6 bg-gray-200 w-48 h-screen border-r-2 border-gray-400" v-if="userAgent">
                <Nav />
            </div>
            <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
                <div :class="[userAgent ? 'flex items-center justify-between px-6 ' : 'bg-gray-200 px-3', 'h-16 border-b border-gray-400']">
                    <div :class="[!userAgent ? 'mx-auto pb-2 py-1 text-xl' : '']">
                        {{ title }}
                    </div>

                    <div class="flex items-center">
                        <div class="pr-4 text-sm">{{ authUser.data.attributes.name }}さん</div>
                        <UserCircle v-if="userAgent" />
                    </div>
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