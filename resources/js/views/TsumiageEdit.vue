<template>
    <div>
        <div id="DateTimeDisp" class="mb-4"></div>
        <Datepicker
            v-model="defaultDate"
            :format="DatePickerFormat"
            :language="ja"
            name="datepicker" class="datapicker-style">
        </Datepicker>

        <div v-if="loading">Loading...</div>
        <div v-else>
        
            <div v-for="(tsumiage, tsumiageKey, index) in tsumiages">
                <form @submit.prevent="submitForm(tsumiageKey)" class="pt-6">
                    <div class="flex justify-items-start">
                        <div class="flex justify-items-center mx-auto">
                            <InputField :key="'item' + tsumiageKey" :name="'item' + tsumiageKey" :label="'積み上げ' + String(parseInt(index) + 1)" :errors="errors"
                            placeholder="積み上げ" @update:field="itemUpdate($event, tsumiageKey)" :data="tsumiage.data.attributes.item" class="pr-2" />
                            <InputField :key="'plan_time' + tsumiageKey" :name="'plan_time' + tsumiageKey" :errors="errors"
                            placeholder="予定作業時間(分)" @update:field="planTimeUpdate($event, tsumiageKey)" :data="tsumiage.data.attributes.plan_time" class="pr-2" />
                            <InputField :key="'actual_time' + tsumiageKey" :name="'actual_time' + tsumiageKey" :errors="errors"
                            placeholder="実績作業時間(分)" @update:field="actualTimeUpdate($event, tsumiageKey)" :data="tsumiage.data.attributes.actual_time" />
                        </div>

                        <div class="flex justify-end pt-3">
                            <button type="button" @click="deleteItem(tsumiage.data.tsumiage_id)" class="p-1 rounded text-red-700 border mr-5 hover:border-red-700 h-9">削除</button>
                            <button class="bg-blue-500 p-1 h-9 text-white rounded hover:bg-blue-400">保存</button>
                        </div>
                    </div>
                </form>
            </div>

            <div v-if="itemNum == 0" class="pt-64"></div>

            <div class="flex justify-start">
                <button v-if="itemNum < 10" type="button" class="p-1 rounded text-sm border mr-3 hover:text-blue-800" 
                @click="itemNum += 1">
                    積み上げ追加
                </button>
            </div>
        </div>

    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import Datepicker from 'vuejs-datepicker';
    import { mapGetters } from 'vuex';

    export default {
        name: "TsumiageEdit",

        components: {
            InputField,
            Datepicker
        },

        mounted() {
            this.getDay();
            
            axios.post('/api/user-tsumiage', {data: this.day})
                .then(response => {
                    this.itemNum = response.data.count;
                    this.tsumiages = response.data.data;

                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    // if (error.response.status === 404) {
                    //     this.$router.push('/home');
                    // }
                });
        },

        data: function() {
            return {
                tsumiages: {},

                errors: null,
                itemNum: 0,
                loading: true,
                day: null,
                loading: true,

                defaultDate: new Date(),
                DatePickerFormat: 'yyyy-MM-dd',
                ja: {
                    language: 'Japanese',
                    months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    monthsAbbr: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    days: ['日', '月', '火', '水', '木', '金', '土'],
                    rtl: false,
                    ymd: 'yyyy-MM-dd',
                    yearSuffix: '年'
                }
            }
        },

        methods: {
            submitForm: function(key) {
                var submitArray = {};
                let tsumiage_id = this.tsumiages[key]['data']['tsumiage_id'];
                submitArray['key'] = key;
                submitArray['item' + key] = this.tsumiages[key]['data']['attributes']['item'];
                submitArray['plan_time' + key] = this.tsumiages[key]['data']['attributes']['plan_time'];
                submitArray['actual_time' + key] = this.tsumiages[key]['data']['attributes']['actual_time'];

                axios.patch('/api/tsumiage/' + tsumiage_id, submitArray)
                    .then(response => {
                        alert("保存しました");
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            deleteItem: function(tsumiage_id) {
                axios.delete('/api/tsumiage/' + tsumiage_id)
                    .then(response => {
                        alert("削除しました");
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });

            },

            itemUpdate: function($event, key) {
                var self = this;
                self.tsumiages[key]['data']['attributes']['item'] = $event;
            },
            planTimeUpdate: function($event, key) {
                var self = this;
                self.tsumiages[key]['data']['attributes']['plan_time'] = $event;
            },
            actualTimeUpdate: function($event, key) {
                var self = this;
                self.tsumiages[key]['data']['attributes']['actual_time'] = $event;
            },

            deleteItem: function() {
                var self = this;
                self.item[self.itemNum] = '';
                self.planTime[self.itemNum] = '';
                self.actualTime[self.itemNum] = '';
                self.itemNum -= 1;
            },

            getDay: function () {
                var now = this.defaultDate;
                var Year = now.getFullYear();
                var Month = ("00" + (now.getMonth()+1)).slice(-2);
                var Day = ("00" + now.getDate()).slice(-2);
                this.day = Year + "-" + Month + "-" + Day;
            },
        },

        computed: {
            ...mapGetters({
                authUser: 'authUser'
            })
        },

        watch: {
            defaultDate: function () {
                this.getDay();
            },
        }
    }
</script>

<style>
    .datapicker-style div input {
        border: 1px ridge #dcdcdc;
        border-radius: 3px;
        text-align: center;
    }
    
</style>