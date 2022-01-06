<template>
    <div>
        <Datepicker
            v-model="defaultDate"
            :format="DatePickerFormat"
            :language="ja"
            name="datepicker" class="datapicker-style">
        </Datepicker>

        <div class="flex justify-end pr-44">
            <label class="text-gray-600 pt-2 uppercase text-xs font-bold absolute">期日</label>
        </div>

        <div v-if="loading">Loading...</div>
        <div v-else class="item-div">
        
            <div v-for="(tsumiage, tsumiageKey, index) in tsumiages">
                <form @submit.prevent="submitForm(tsumiageKey)" class="pt-6">
                    <div class="flex justify-items-center mx-auto">
                        <InputField :key="'item' + tsumiageKey" :name="'item' + tsumiageKey" :label="'積み上げ' + String(parseInt(index) + 1)" :errors="errors"
                        placeholder="積み上げ" @update:field="itemUpdate($event, tsumiageKey)" :data="tsumiage.data.attributes.item" class="pr-2 w-1/3" />
                        <InputField :key="'plan_time' + tsumiageKey" :name="'plan_time' + tsumiageKey" :errors="errors"
                        placeholder="予定時間" @update:field="planTimeUpdate($event, tsumiageKey)" :data="tsumiage.data.attributes.plan_time" class="pr-2 w-1/5" />
                        <InputField :key="'actual_time' + tsumiageKey" :name="'actual_time' + tsumiageKey" :errors="errors"
                        placeholder="実績時間" @update:field="actualTimeUpdate($event, tsumiageKey)" :data="tsumiage.data.attributes.actual_time" class="pr-2 w-1/5" />
                        <Datepicker
                                v-model="tsumiage.data.attributes.due"
                                :format="DatePickerFormat"
                                :language="ja"
                                name="datepicker" class="datapicker-style pr-2 py-7">
                        </Datepicker>

                        <button type="button" @click="deleteItem(tsumiage.data.tsumiage_id)" :class="[userAgent? 'mr-3' : 'mr-1', 'p-1 mt-5 rounded text-red-700 border hover:border-red-700 h-9 w-12']">
                            <div v-if="userAgent" class="text-sm">削除</div>
                            <div v-else class="text-xl">×</div>
                        </button>
                        <button class="bg-blue-500 p-1  mt-5 h-9 text-white rounded hover:bg-blue-400 text-sm w-12">保存</button>
                    </div>
                </form>
            </div>
            <p class="text-sm">※予定時間・実績時間は分で入力して下さい</p>

            <form @submit.prevent="submitAddItem()" class="pt-6">
                <div>
                    <div v-for="n in addItemNum">
                        <div class="flex justify-items-center mx-auto">
                            <InputField :key="'add_item' + n" :name="'add_item' + n" :label="'追加' + n" :errors="errors"
                            placeholder="積み上げ" @update:field="addItemUpdate($event, n)" :data="item[n]" class="pr-2 w-1/2" />
                            <InputField :key="'add_plan_time' + n" :name="'add_plan_time' + n" :errors="errors"
                            placeholder="予定時間" @update:field="addPlanTimeUpdate($event, n)" :data="planTime[n]" class="pr-2 w-1/4" />
                            <InputField :key="'add_actual_time' + n" :name="'add_actual_time' + n" :errors="errors"
                            placeholder="実績時間" @update:field="addActualTimeUpdate($event, n)" :data="actualTime[n]" class=" w-1/4" />
                            <Datepicker
                                v-model="due[n]"
                                :format="DatePickerFormat"
                                :language="ja"
                                name="datepicker" class="datapicker-style pl-2 py-7">
                            </Datepicker>
                        </div>
                    </div>

                    <div :class="[userAgent? 'justify-start' : 'justify-between', 'flex pl-1']">
                        <button v-if="(parseInt(addItemNum) + parseInt(itemNum)) < 10" type="button" class="p-1 rounded text-sm border mr-3 hover:text-blue-800" 
                        @click="addItemNum += 1">
                            積み上げ追加
                        </button>
                        <button v-if="addItemNum > 0" type="button" class="p-1 rounded text-sm border mr-3 hover:text-blue-800" 
                        @click="deleteAddItem(addItemNum); addItemNum -= 1;">
                            <div v-if="userAgent">追加積み上げ削除</div>
                            <div v-else>追加積み上げ<br>削除</div>
                        </button>
                        <button v-if="addItemNum > 0" class="bg-blue-500 p-1 text-sm text-white rounded hover:bg-blue-400">
                            <div v-if="userAgent">追加積み上げ保存</div>
                            <div v-else>追加積み上げ<br>保存</div>
                        </button>
                    </div>
                </div>
            </form>

            <div v-if="addItemNum == 0" class="pl-1">
                <br>
                <a :href="tweet" target="_blank" class="pt-2">
                    <div class="w-24 bg-green-400 text-sm text-white p-1 rounded hover:bg-green-300 text-center">ツイート投稿</div>
                </a>
            </div>
            <div class="pt-44"></div>
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
            this.getDate(this.$route.params.day);
            this.getTsumiage();
        },

        data: function() {
            return {
                tsumiages: {},

                errors: null,
                itemNum: 0,
                addItemNum: 0,
                loading: true,
                day: null,
                yyyymmdd: null,
                loading: true,
                tweet: '',

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
                },

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
            }
        },

        methods: {
            submitForm: function(key) {
                let submitArray = {};
                let tsumiage_id = this.tsumiages[key]['data']['tsumiage_id'];
                submitArray['key'] = key;
                submitArray['item' + key] = this.tsumiages[key]['data']['attributes']['item'];
                submitArray['plan_time' + key] = this.tsumiages[key]['data']['attributes']['plan_time'];
                submitArray['actual_time' + key] = this.tsumiages[key]['data']['attributes']['actual_time'];
                
                if (this.tsumiages[key]['data']['attributes']['due'] !== null) {
                    let now = this.tsumiages[key]['data']['attributes']['due'];
                    let Year = now.getFullYear();
                    let Month = ("00" + (now.getMonth()+1)).slice(-2);
                    let Day = ("00" + now.getDate()).slice(-2);
                    let due = Year + "-" + Month + "-" + Day;
                    submitArray['due' + key] = due;
                }

                axios.patch('/api/tsumiage/' + tsumiage_id, submitArray)
                    .then(response => {
                        alert("保存しました");
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            submitAddItem: function() {
                let submitArray = {};
                submitArray['date'] = this.day;

                for (let i = 1; i < this.addItemNum + 1; i++) {
                    submitArray['add_item' + i] = this.item[i];
                    submitArray['add_plan_time' + i] = this.planTime[i];
                    submitArray['add_actual_time' + i] = this.actualTime[i];

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
                        this.getTsumiage();
                        this.allDeleteAddItem();

                        if (this.yyyymmdd == this.today) {
                            this.$store.dispatch('updateTsumiageCountAction', this.itemNum);
                        }
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            deleteItem: function(tsumiage_id) {
                axios.delete('/api/tsumiage/' + tsumiage_id)
                    .then(response => {
                        alert("削除しました");
                        this.getTsumiage();
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });

            },

            getTsumiage: function() {
                axios.post('/api/user-tsumiage', {date: this.day})
                    .then(response => {
                        if (response.data.count == 0) {
                            this.$router.push('/tsumiage/create/' + this.yyyymmdd);
                        } else {
                            this.itemNum = response.data.count;
                            this.tsumiages = response.data.data;

                            let tsumiageArray = Object.values(this.tsumiages);
                            var tweet = 'https://twitter.com/intent/tweet?hashtags=今日の積み上げ&text=';

                            tsumiageArray.forEach(function(element){
                                tweet += '・' + element.data.attributes.item + '%0a';
                            });
                            tweet += '%0a';
                            this.tweet = tweet;
                        }

                        if (this.yyyymmdd == this.today) {
                            this.$store.dispatch('updateTsumiageCountAction', response.data.count);
                        }

                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;

                        // if (error.response.status === 404) {
                        //     this.$router.push('/home');
                        // }
                    });

            },

            deleteAddItem: function(addItemNum) {
                var self = this;
                self.item[addItemNum] = '';
                self.planTime[addItemNum] = '';
                self.actualTime[addItemNum] = '';
                self.due[addItemNum] = '';
            },

            allDeleteAddItem: function() {
                for (let i = 1; i < this.addItemNum + 1; i++) {
                    this.deleteAddItem(i);
                }
                this.addItemNum = 0;
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

            addItemUpdate: function($event, n) {
                var self = this;
                self.item[n] = $event;
            },
            addPlanTimeUpdate: function($event, n) {
                var self = this;
                self.planTime[n] = $event;
            },
            addActualTimeUpdate: function($event, n) {
                var self = this;
                self.actualTime[n] = $event;
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
        },

        computed: {
            ...mapGetters({
                authUser: 'authUser',
                // this.todayをthis.$store.getters.yyyymmddにマッピングさせる
                today: 'yyyymmdd',
                userAgent: 'userAgent'
            })
        },

        watch: {
            defaultDate: function () {
                this.addItemNum = 0;
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