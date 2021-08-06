<template>
    <div>
        <div id="DateTimeDisp" class="mb-4"></div>

        <form @submit.prevent="submitForm" class="pt-6">
    
            <div v-for="n in itemNum">
                <div class="flex justify-items-center mx-auto">
                    <InputField :key="'item' + n" :name="'item' + n" :label="'積み上げ' + n" :errors="errors"
                    placeholder="積み上げ" @update:field="itemUpdate($event, n)" :data="item[n]" class="pr-2" />
                    <InputField :key="'plan_time' + n" :name="'plan_time' + n" :errors="errors"
                    placeholder="予定作業時間(分)" @update:field="planTimeUpdate($event, n)" :data="planTime[n]" class="pr-2" />
                    <InputField :key="'actual_time' + n" :name="'actual_time' + n" :errors="errors"
                    placeholder="実績作業時間(分)" @update:field="actualTimeUpdate($event, n)" :data="actualTime[n]" />
                </div>
            </div>

            <div class="flex justify-start">
                <button v-if="itemNum < 10" type="button" class="p-1 rounded text-sm border mr-3 hover:text-blue-800" 
                @click="itemNum += 1">
                    積み上げ追加
                </button>
                <button v-if="itemNum > 0" type="button" class="p-1 rounded text-sm border mr-5 hover:text-red-800"
                @click="itemNum -= 1">
                    積み上げ削除
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
</template>

<script>
    import InputField from '../components/InputField';

    export default {
        name: "TsumiageEdit",

        components: {
            InputField
        },

        mounted() {
            this.displayToday();
            
            // axios.get('/api/items/' + this.$route.params.id)
            //     .then(response => {
            //         this.form = response.data.data.attributes;
            //         this.itemNum = response.data.data.item_num;
            //         this.loading = false;
            //     })
            //     .catch(error => {
            //         this.loading = false;

            //         if (error.response.status === 404) {
            //             this.$router.push('/home');
            //         }
            //     });
        },

        data: function() {
            return {
                item: {
                    1 : '', 2 : '', 3 : '', 4 : '', 5 : '', 6 : '', 7 : '', 8 : '', 9 : '', 10 : '',
                },
                planTime: {
                    1 : '', 2 : '', 3 : '', 4 : '', 5 : '', 6 : '', 7 : '', 8 : '', 9 : '', 10 : '',
                },
                actualTime: {
                    1 : '', 2 : '', 3 : '', 4 : '', 5 : '', 6 : '', 7 : '', 8 : '', 9 : '', 10 : '',
                },

                errors: null,

                itemNum: 3,

                loading: true,

                today: null,
            }
        },

        methods: {
            submitForm: function() {
                var submitArray = {};
                submitArray['tsumiage'] = {};
                
                for (let i = 1; i < this.itemNum + 1; i++) {
                    let tsumiage = {};
                    tsumiage['item'] = this.item[i];
                    tsumiage['plan_time'] = this.planTime[i];
                    tsumiage['actual_time'] = this.actualTime[i];
                    tsumiage['today'] = this.today;

                    submitArray['tsumiage'][i] = tsumiage;
                }

                axios.post('/api/tsumiage', submitArray)
                    .then(response => {
                        alert("保存しました");
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            itemUpdate: function($event, n) {
                var self = this;
                self.item[n] = $event;
            },
            planTimeUpdate: function($event, n) {
                var self = this;
                self.planTime[n] = $event;
            },
            actualTimeUpdate: function($event, n) {
                var self = this;
                self.actualTime[n] = $event;
            },

            displayToday: function () {
                var now = new Date();
                var Year = now.getFullYear();
                var Month = ("00" + (now.getMonth()+1)).slice(-2);
                var Day = ("00" + now.getDate()).slice(-2);
                document.getElementById("DateTimeDisp").innerHTML = Year + "/" + Month + "/" + Day;
                this.today = Year + Month +Day;
            },
        }
    }
</script>

<style scoped>

</style>