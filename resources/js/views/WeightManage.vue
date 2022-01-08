<template>
    <div>
        <Datepicker
            v-model="defaultDate"
            :format="DatePickerFormat"
            :language="ja"
            name="datepicker" class="datapicker-style">
        </Datepicker>

        <div v-if="loading">Loading...</div>
        <div v-else class="item-div">

            <form @submit.prevent="submitForm" class="pt-6">
                <div class="flex justify-items-center mx-auto">
                    <InputField name="weight" label="体重" :errors="errors"
                        placeholder="体重[kg]" @update:field="form.weight = $event" :data="form.weight" /><br>
                </div>

                <div class="flex justify-items-center mx-auto">
                    <InputField name="breakfast" label="朝食" :errors="errors"
                        placeholder="朝食内容" @update:field="form.breakfast = $event" :data="form.breakfast" class="pr-2 w-1/4" />
                    <InputField name="lunch" label="昼食" :errors="errors"
                        placeholder="昼食内容" @update:field="form.lunch = $event" :data="form.lunch" class="pr-2 w-1/4" />
                    <InputField name="supper" label="晩飯" :errors="errors"
                        placeholder="晩飯内容" @update:field="form.supper = $event" :data="form.supper" class="pr-2 w-1/4" />
                    <InputField name="snack" label="間食" :errors="errors"
                        placeholder="間食内容" @update:field="form.snack = $event" :data="form.snack" class="pr-2 w-1/4" />
                </div>

                <div class="flex justify-items-center mx-auto">
                    <InputField name="breakfast_calories" :errors="errors"  class="pr-2 w-1/4"
                        placeholder="朝食のカロリー" @update:field="form.breakfast_calories = $event; totalCalUpdate();" :data="form.breakfast_calories" />
                    <InputField name="lunch_calories" :errors="errors" class="pr-2 w-1/4"
                        placeholder="昼食のカロリー" @update:field="form.lunch_calories = $event; totalCalUpdate();" :data="form.lunch_calories" />
                    <InputField name="supper_calories" :errors="errors" class="pr-2 w-1/4"
                        placeholder="晩飯のカロリー" @update:field="form.supper_calories = $event; totalCalUpdate();" :data="form.supper_calories" />
                    <InputField name="snack_calories" :errors="errors" class="pr-2 w-1/4"
                        placeholder="間食のカロリー" @update:field="form.snack_calories = $event; totalCalUpdate();" :data="form.snack_calories" />
                </div>

                <div>
                    合計 {{ form.total_calories }}kcal
                </div>

                <div class="flex justify-end">
                    <router-link to="/home" class="p-1 rounded text-red-700 border mr-3 hover:border-red-700 text-sm flex items-center">
                        <div>キャンセル</div>
                    </router-link>
                    <button class="bg-blue-500 px-3 text-white rounded hover:bg-blue-400 text-sm">保存</button>
                </div>
            </form>

            <div class="pl-1">
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
        name: "WeightManage",

        components: {
            InputField,
            Datepicker
        },

        mounted() {
            this.getDate(this.$route.params.day);
            this.getWeight();
        },

        data: function() {
            return {
                weight: {},

                errors: null,
                loading: true,
                day: null,
                yyyymmdd: null,
                loading: true,
                tweet: '',
                recordExists: false,
                record_id: '',

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

                form: {
                    'weight': '',
                    'breakfast': '',
                    'lunch': '',
                    'supper': '',
                    'snack': '',
                    'breakfast_calories': '0',
                    'lunch_calories': '0',
                    'supper_calories': '0',
                    'snack_calories': '0',
                    'total_calories': '0',
                    'record_id' : '',
                },
            }
        },

        methods: {
            submitForm: function() {
                let submitArray = {};

                submitArray['date'] = this.day;
                submitArray['weight'] = this.form.weight;
                submitArray['breakfast'] = this.form.breakfast;
                submitArray['lunch'] = this.form.lunch;
                submitArray['supper'] = this.form.supper;
                submitArray['snack'] = this.form.snack;
                submitArray['breakfast_calories'] = this.form.breakfast_calories;
                submitArray['lunch_calories'] = this.form.lunch_calories;
                submitArray['supper_calories'] = this.form.supper_calories;
                submitArray['snack_calories'] = this.form.snack_calories;
                submitArray['total_calories'] = this.form.total_calories;

                if (this.recordExists) {
                    // データ更新
                    axios.patch('/api/weight/' + this.record_id, submitArray)
                        .then(response => {
                            alert("保存しました");
                        })
                        .catch(errors => {
                            this.errors = errors.response.data.errors;
                        });
                } else {
                    // データ新規作成
                    axios.post('/api/weight', submitArray)
                        .then(response => {
                            alert("保存しました");
                        })
                        .catch(errors => {
                            this.errors = errors.response.data.errors;
                        });
                }
 
            },

            getWeight: function() {
                axios.post('/api/daily-weight', {date: this.day})
                    .then(response => {
                        if (response.data) {
                            this.form = response.data.data.attributes;
                            this.recordExists = true;
                            this.record_id = response.data.data.weight_id;
                        } else {
                            this.form.weight = "";
                            this.form.breakfast = "";
                            this.form.lunch = "";
                            this.form.supper = "";
                            this.form.snack = "";
                            this.form.breakfast_calories = "0";
                            this.form.lunch_calories = "0";
                            this.form.supper_calories = "0";
                            this.form.snack_calories = "0";
                            this.form.total_calories = "0";
                            this.recordExists = false;
                            this.record_id = "";
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

            totalCalUpdate: function() {
                this.form.total_calories = Number(this.form.breakfast_calories) + Number(this.form.lunch_calories) + Number(this.form.supper_calories) + Number(this.form.snack_calories);
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
                this.getDay();
                this.getWeight();
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