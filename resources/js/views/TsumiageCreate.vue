<template>
    <div>
        <div id="DateTimeDisp" class="mb-4"></div>
        <Datepicker
            v-model="defaultDate"
            :format="DatePickerFormat"
            :language="ja"
            name="datepicker" class="datapicker-style">
        </Datepicker>

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
                @click="deleteItem()">
                    積み上げ削除
                </button>
            </div>

            <div class="flex justify-end">
                <router-link to="/home" class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">
                    キャンセル
                </router-link>
                <button v-if="itemNum > 0" class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">保存</button>
            </div>
        </form>

    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import Datepicker from 'vuejs-datepicker';

    export default {
        name: "TsumiageCreate",

        components: {
            InputField,
            Datepicker
        },

        mounted() {
            this.getDate(this.$route.params.day);
            this.getDay();
            this.getTsumiage();
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
                day: null,
                yyyymmdd: null,

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
            submitForm: function() {
                var submitArray = {};
                submitArray['date'] = this.day;

                for (let i = 1; i < this.itemNum + 1; i++) {
                    submitArray['item' + i] = this.item[i];
                    submitArray['plan_time' + i] = this.planTime[i];
                    submitArray['actual_time' + i] = this.actualTime[i];
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
                this.yyyymmdd = Year + Month + Day;
            },

            getDate: function (yyyymmdd) {
                let y = yyyymmdd.substr(0, 4);
                let m = yyyymmdd.substr(4, 2);
                let d = yyyymmdd.substr(6, 2);
                this.defaultDate = new Date(y, m - 1, d); 
            },

            getTsumiage: function() {
                axios.post('/api/user-tsumiage', {data: this.day})
                    .then(response => {
                        if (response.data.count != 0) {
                            this.$router.push('/tsumiage/edit/' + this.yyyymmdd);
                        } 
                    })
                    .catch(error => {

                    });

            },
        },

        watch: {
            defaultDate: function () {
                this.getDay();
                this.getTsumiage();
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