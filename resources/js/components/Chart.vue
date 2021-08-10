<template>
  <div class="small">
    <h1>vue-chartjs</h1>
    <div class="half">
      <doughnut-chart :chart-data="doughnutcollection"></doughnut-chart>
    </div>
    <div class="half">
      <BarChart :chart-data="datacollection"></BarChart>
    </div>
    <div>
      <input type="text" v-model="lines">
      <button @click="fillData()">Repaint</button>
      <button @click="randomize()">Randomize</button>
    </div>
  </div>
</template>

<script>
import BarChart from   '../chart/BarChart.js'
import DoughnutChart from '../chart/DoughnutChart.js'
export default {
  components: {
    BarChart,
    DoughnutChart,
  },
  data () {
    return {
      datacollection: { labels:[], datasets: [] },
      doughnutcollection: { labels:[], datasets: [] },
      lines: 3,
    }
  },
  mounted () {
    this.fillData()
  },
  methods: {
    fillData () {
      var datasets = []
      var dDatasets = []
      var labels = []
      var val = 0
      var dLabels = []
      var dColors = []
      var min = 0
      var max = 0
      var loopCnt = this.lines
      for (var i = 0; i < loopCnt;i++) {
        labels = [this.getRandomInt(), this.getRandomInt()]
        if (max < labels[0]) {
          max = labels[0]
        }
        if (max < labels[1]) {
          max = labels[1]
        }
        datasets.push({
          label: 'data-' + (i + 1),
          backgroundColor: 'rgba(255,100,100,0.1)',
          data: labels,
        })
        dLabels.push('data-' + (i + 1))
        dDatasets.push(this.getRandomInt())
        var code = i * 20
        dColors.push('rgba(255,'+code+','+code+',0.4)')
      }
      this.datacollection = {
        labels: [min, max],
        datasets: datasets
      }
      this.doughnutcollection = {
        labels: dLabels,
        datasets: [
        {
          data: dDatasets,
          backgroundColor: dColors
        }
        ]
      }
    },
    randomize () {
      this.lines = Math.floor(Math.random() * 10) + 1;
      this.fillData();
    },
    getRandomInt () {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 5
    }
  }
}
</script>

<style>
.small {
  margin:  100px auto;
}
.half {
  width: 45%;
  display: inline-block;
}
</style>