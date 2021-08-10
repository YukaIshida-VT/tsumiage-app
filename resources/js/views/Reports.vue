<template>
    <div>
        <Datepicker
            v-model="defaultDate"
            :format="DatePickerFormat"
            :language="ja"
            name="datepicker" class="datapicker-style">
        </Datepicker>
        <BarChart :chart-data="monthlyDatacollection"></BarChart>
        <BarChart :chart-data="weeklyDatacollection"></BarChart>

        <div class="pt-64"></div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import BarChart from   '../chart/BarChart.js';

    export default {
        name: "Reports",

        components: {
            Datepicker,
            BarChart,
        },

        mounted() {
            this.getDay();
            this.getTsumiage();
        },

        data: function() {
            return {
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
                },

                monthlyDatacollection: { labels:[], datasets: [] },
                monthlyLabels: [],
                monthlyDatasets: [
                    {
                        label: '今月の積み上げ集計(1日から月末を集計)',
                        data: [],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                ],     
                
                weeklyDatacollection: { labels:[], datasets: [] },
                weeklyLabels: [],
                weeklyDatasets: [
                    {
                        label: '今週の積み上げ集計(月曜日から日曜日を集計)',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                ], 
            }
        },

        methods: {
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
                axios.post('/api/tsumiage-sum', {yyyymmdd: this.yyyymmdd})
                    .then(response => {
                        let monthlyTsumiageSum = Object.values(response.data.monthly_tsumiage_sum);
                        let monthlyLabels = [];
                        let monthlyData = [];

                        monthlyTsumiageSum.forEach(function(element, index){
                            monthlyLabels.push(element.item);
                            monthlyData.push(element.actual_time);
                        });
                        
                        this.monthlyLabels = monthlyLabels;
                        this.monthlyDatasets[0].data = monthlyData;

                        this.monthlyDatacollection = {
                            labels: this.monthlyLabels,
                            datasets: this.monthlyDatasets
                        };

                        let weeklyTsumiageSum = Object.values(response.data.weekly_tsumiage_sum);
                        let weeklyLabels = [];
                        let weeklyData = [];

                        weeklyTsumiageSum.forEach(function(element, index){
                            weeklyLabels.push(element.item);
                            weeklyData.push(element.actual_time);
                        });
                        
                        this.weeklyLabels = weeklyLabels;
                        this.weeklyDatasets[0].data = weeklyData;

                        this.weeklyDatacollection = {
                            labels: this.weeklyLabels,
                            datasets: this.weeklyDatasets
                        };

                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;

                        // if (error.response.status === 404) {
                        //     this.$router.push('/home');
                        // }
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