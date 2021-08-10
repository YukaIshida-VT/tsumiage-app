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
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
            ],
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