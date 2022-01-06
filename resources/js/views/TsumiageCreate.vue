<template>
    <div>
        <Datepicker
            v-model="defaultDate"
            :format="DatePickerFormat"
            :language="ja"
            name="datepicker" class="datapicker-style">
        </Datepicker>

        <div class="flex justify-end pr-12">
            <label class="text-gray-600 pt-2 uppercase text-xs font-bold absolute">期日</label>
        </div>

        <form @submit.prevent="submitForm" class="pt-6">
            <div v-for="n in itemNum" class="item-div">
                <div class="flex justify-items-center mx-auto">
                    <InputField :key="'item' + n" :name="'add_item' + n" :label="'積み上げ' + n" :errors="errors"
                    placeholder="積み上げ" @update:field="itemUpdate($event, n)" :data="item[n]" class="pr-2 w-1/2" />
                    <InputField :key="'plan_time' + n" :name="'add_plan_time' + n" :errors="errors"
                    placeholder="予定時間" @update:field="planTimeUpdate($event, n)" :data="planTime[n]" class="pr-2 w-1/4" />
                    <InputField :key="'actual_time' + n" :name="'add_actual_time' + n" :errors="errors"
                    placeholder="実績時間" @update:field="actualTimeUpdate($event, n)" :data="actualTime[n]" class=" w-1/4" />
                    <Datepicker
                        v-model="due[n]"
                        :format="DatePickerFormat"
                        :language="ja"
                        name="datepicker" class="datapicker-style pl-2 py-7">
                    </Datepicker>
                </div>
            </div>
            <p class="text-sm">※予定時間・実績時間は分で入力して下さい</p><br>

            <div class="flex justify-between">
                <div class="flex">
                    <button v-if="itemNum < 10" type="button" class="p-1 rounded text-sm border mr-3 hover:text-blue-800" 
                    @click="itemNum += 1">
                        <div v-if="userAgent">積み上げ追加</div>
                        <div v-else>積み上げ<br>追加</div>
                    </button>
                    <button v-if="itemNum > 0" type="button" class="p-1 rounded text-sm border mr-5 hover:text-red-800"
                    @click="deleteItem()">
                        <div v-if="userAgent">積み上げ削除</div>
                        <div v-else>積み上げ<br>削除</div>
                    </button>
                </div>

                <div class="flex justify-end">
                    <router-link to="/home" class="p-1 rounded text-red-700 border mr-3 hover:border-red-700 text-sm flex items-center">
                        <div>キャンセル</div>
                    </router-link>
                    <button v-if="itemNum > 0" class="bg-blue-500 px-3 text-white rounded hover:bg-blue-400 text-sm">保存</button>
                </div>
            </div>

        </form>

        <div class="pt-48"></div>
    </div>
</template>

<script>
    import InputField from '../components/InputField';
    import Datepicker from 'vuejs-datepicker';
    import { mapGetters } from 'vuex';

    export default {
        name: "TsumiageCreate",

        components: {
            InputField,
            Datepicker
        },

        mounted() {
            this.getDate(this.$route.params.day);
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
                due: {
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
                    submitArray['add_item' + i] = this.item[i];
                    submitArray['add_plan_time' + i] = this.planTime[i];
                    submitArray['add_actual_time' + i] = this.actualTime[i];
                    console.log(this.due[i]);

                    if (this.due[i] != '') {
                        let now = this.due[i];
                        let Year = now.getFullYear();
                        let Month = ("00" + (now.getMonth()+1)).slice(-2);
                        let Day = ("00" + now.getDate()).slice(-2);
                        let due = Year + "-" + Month + "-" + Day;
                        submitArray['add_due' + i] = due;
                    }
                }

                axios.post('/api/tsumiage', submitArray)
                    .then(response => {
                        alert("保存しました");
                        this.$router.push('/tsumiage/edit/' + this.yyyymmdd);
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
                let now = this.defaultDate;
                let Year = now.getFullYear();
                let Month = ("00" + (now.getMonth()+1)).slice(-2);
                let Day = ("00" + now.getDate()).slice(-2);
                this.day = Year + "-" + Month + "-" + Day;
                this.yyyymmdd = Year + Month + Day;
            },

            getDate: function (yyyymmdd) {
                let Year = yyyymmdd.substr(0, 4);
                let Month = yyyymmdd.substr(4, 2);
                let Day = yyyymmdd.substr(6, 2);
                this.defaultDate = new Date(Year, Month - 1, Day); 
                this.day = Year + "-" + Month + "-" + Day;
            },

            getTsumiage: function() {
                axios.post('/api/user-tsumiage', {date: this.day})
                    .then(response => {
                        if (response.data.count != 0) {
                            this.$router.push('/tsumiage/edit/' + this.yyyymmdd);
                        }

                        if (this.yyyymmdd == this.today) {
                            this.$store.dispatch('updateTsumiageCountAction', response.data.count);
                        }
                    })
                    .catch(error => {

                    });

            },
        },

        computed: {
            ...mapGetters({
                // this.todayをthis.$store.getters.yyyymmddにマッピングさせる
                today: 'yyyymmdd',
                userAgent: 'userAgent'
            })
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

    .item-div .vdp-datepicker__calendar {
        right: 0px;
    }
</style>