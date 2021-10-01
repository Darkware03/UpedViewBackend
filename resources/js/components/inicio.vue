<template>
<example-component></example-component>
</template>
<script>
  import { Line } from 'vue-chartjs'
import ExampleComponent from './ExampleComponent.vue'

  export default {
  components: { ExampleComponent },
    extends: Line,
    data () {
      return {
        chartData: {
          labels: ["Ciencias Juridicas",	"Ciencias Economia",	"Ingenieria",	"Ciencias de la Educacion",	"Posgrados"],
          datasets: [
            {
              label: 'Promedio Likes por Facultad',
              data: [600,	1150,	342,	6050,	2522],
              fill: false,
              borderColor: '#2554FF',
              backgroundColor: '#2554FF',
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              },
              gridLines: {
                display: true
              }
            }],
            xAxes: [ {
              gridLines: {
                display: false
              }
            }]
          },
          legend: {
            display: true
          },
          responsive: true,
          maintainAspectRatio: false
        }
      }
    },
    mounted () {
      this.renderChart(this.chartData, this.options)
    }
  }
</script>