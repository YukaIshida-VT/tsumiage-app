<template>
  <div class="small">
    <h1>vue-chartjs</h1>
      <BarChart :chart-data="datacollection"></BarChart>
    <div>
    </div>
  </div>
</template>

<script>
import BarChart from   '../chart/BarChart.js'

export default {
  components: {
    BarChart,
  },
   data () {
    return {
        datacollection: { labels:[], datasets: [] },
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        // lines: 6,
        datasets: [
          {
            label: 'Bar Dataset',
            data: [10, 20, 30, 40, 50, 30],
            backgroundColor: 'lightblue',
            borderWidth: 1
          },
        //   {
        //     label: 'Line Dataset',
        //     data: [10, 50, 20, 30, 30, 40],
        //     borderColor: '#CFD8DC',
        //     fill: false,
        //     type: 'line',
        //     lineTension: 0.3,
        //   }
        ]
    }
  },
  mounted () {
    this.fillData();
  },
  methods: {
    fillData () {
    this.datacollection = {
        labels: this.labels,
        datasets: this.datasets
      };
    },
  }
}
</script>

<style>
.small {
  margin:  100px auto;
}
</style>