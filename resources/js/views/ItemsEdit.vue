<template>
    <div>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()">
                < Back
            </a>
        </div>

        <form @submit.prevent="submitForm" class="pt-6">
    
            <InputField v-for="n in 5" :key="n" :name="'item' + n" :label="'項目' + n" :errors="errors"
                placeholder="" @update:field="itemUpdate($event, n)" :data="'form.item' + n" />

            <div class="flex justify-end">
                <router-link to="/home" class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">
                    Cancel
                </router-link>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from '../components/InputField';

    export default {
        name: "ItemsEdit",

        components: {
            InputField
        },

        mounted() {
            // axios.get('/api/contacts/' + this.$route.params.id)
            //     .then(response => {
            //         this.form = response.data.data;
            //         this.loading = false;
            //     })
            //     .catch(error => {
            //         this.loading = false;

            //         if (error.response.status === 404) {
            //             this.$router.push('/contacts');
            //         }
            //     });
        },

        data: function() {
            return {
                form: {
                    item1 : '',
                    item2 : '',
                    item3 : '',
                    item4 : '',
                    item5 : '',
                    item6 : '',
                    item7 : '',
                    item8 : '',
                    item9 : '',
                    item10 : '',
                },

                errors: null,
            }
        },

        methods: {
            submitForm: function() {
                // 次ここのsubmitから実装(テーブルどうするか？１ユーザー１レコード？)
                console.log(this.form);
            //     axios.patch('/api/contacts/' + this.$route.params.id, this.form)
            //         .then(response => {
            //             this.$router.push(response.data.links.self);
            //         })
            //         .catch(errors => {
            //             this.errors = errors.response.data.errors;
            //         });
            },

            itemUpdate: function($event, n) {
                var self = this;
                var keyName = 'item' + n;
                self.form[keyName] = $event;
                console.log(self.form);
            }
        }
    }
</script>

<style scoped>

</style>