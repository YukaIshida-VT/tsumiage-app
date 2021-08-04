<template>
    <div>
        <div class="flex justify-between">
            <a href="#" class="text-blue-400" @click="$router.back()">
                < Back
            </a>
        </div>

        <div v-if="loading">Loading...</div>
        <div v-else>
            <form @submit.prevent="submitForm" class="pt-6">
        
                <InputField v-for="n in itemNum" :key="n" :name="'item' + n" :label="'項目' + n" :errors="errors"
                    placeholder="" @update:field="itemUpdate($event, n)" :data="form[n]" />

                <div class="flex justify-start">
                    <button v-if="itemNum < 20" type="button" class="p-1 rounded text-sm border mr-3 hover:text-blue-800" 
                    @click="itemNum += 1">
                        項目追加
                    </button>
                    <button v-if="itemNum > 0" type="button" class="p-1 rounded text-sm border mr-5 hover:text-red-800"
                    @click="itemNum -= 1">
                        項目削除
                    </button>
                </div>

                <div class="flex justify-end">
                    <router-link to="/home" class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">
                        キャンセル
                    </router-link>
                    <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">保存</button>
                </div>
            </form>
        </div>
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
            axios.get('/api/items/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data.attributes;
                    this.itemNum = response.data.data.item_num;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    if (error.response.status === 404) {
                        this.$router.push('/home');
                    }
                });
        },

        data: function() {
            return {
                form: {
                    1 : '', 2 : '', 3 : '', 4 : '', 5 : '', 6 : '', 7 : '', 8 : '', 9 : '', 10 : '',
                    11 : '', 12 : '', 13 : '', 14 : '', 15 : '', 16 : '', 17 : '', 18 : '', 19 : '', 20 : '',
                },

                errors: null,

                itemNum: 0,

                loading: true,
            }
        },

        methods: {
            submitForm: function() {
                var submitArray = {};
                for (let i = 1; i < this.itemNum + 1; i++) {
                    let key = 'item' + i;
                    submitArray[key] = this.form[i];
                }

                axios.patch('/api/items/' + this.$route.params.id, submitArray)
                    .then(response => {
                        alert("保存しました");
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            itemUpdate: function($event, n) {
                var self = this;
                self.form[n] = $event;
            }
        }
    }
</script>

<style scoped>

</style>