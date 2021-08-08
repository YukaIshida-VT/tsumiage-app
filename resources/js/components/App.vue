<template>
    <div class="h-screen bg-white">
        <div class="flex" v-if="authUser">
            <div class="pl-6 bg-gray-200 w-48 h-screen border-r-2 border-gray-400">
                <Nav />
            </div>
            <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
                <div class="h-16 px-6 border-b border-gray-400 flex items-center justify-between">
                    <div>
                        {{ title }}
                    </div>

                    <div class="flex items-center">
                        <div class="pr-4 text-sm">{{ authUser.data.attributes.name }}さん</div>
                        <UserCircle />
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
                authUser: 'authUser'
            })
        },

        components: {
            UserCircle,
            SearchBar,
            Nav
        },

        mounted() {
            this.$store.dispatch('fetchAuthUser');
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