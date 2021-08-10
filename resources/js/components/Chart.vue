<template>
  <div class="small">
    <h1>vue-chartjs</h1>
      <BarChart :chart-data="datacollection"></BarChart>
    <div>
      <input type="text" v-model="lines">
      <button @click="fillData()">Repaint</button>
      <button @click="randomize()">Randomize</button>
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
      lines: 3,
    }
  },
  mounted () {
    this.fillData();
  },
  methods: {
    fillData () {
      var datasets = [];
      var labels = [];
      var val = 0;
      var min = 0;
      var max = 0;
      var loopCnt = this.lines;
      for (var i = 0; i < loopCnt;i++) {
        labels = [this.getRandomInt(), this.getRandomInt()]
        if (max < labels[0]) {
          max = labels[0];
        }
        if (max < labels[1]) {
          max = labels[1];
        }
        datasets.push({
          label: 'data-' + (i + 1),
          backgroundColor: 'rgba(255,100,100,0.1)',
          data: labels,
        })
        var code = i * 20;
      }

      this.datacollection = {
        labels: [min, max],
        datasets: datasets
      };
    },
    randomize () {
      this.lines = Math.floor(Math.random() * 10) + 1;
      this.fillData();
    },
    getRandomInt () {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
    }
  }
}
</script>

<style>
.small {
  margin:  100px auto;
}
</style>