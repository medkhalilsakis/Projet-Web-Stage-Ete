<template>
  <div class="charts-container">
    <div class="chart">
      <Bar :data="barChartData" :options="barChartOptions" />
      <h3 class="chart-title">Le taux actuel de réservations</h3>
    </div>
    <div class="chart">
      <Pie :data="pieChartData" :options="pieChartOptions" />
      <h3 class="chart-title">Répartition des clients par genre</h3>
    </div>
    <div class="chart">
      <Line :data="lineChartData" :options="lineChartOptions" />
      <h3 class="chart-title">Répartition du nombre de chambres par hébergement</h3>
    </div>
    <div class="chart">
      <Doughnut :data="doughnutChartData" :options="doughnutChartOptions" />
      <h3 class="chart-title">Répartition des hébergements</h3>
    </div>
  </div>
</template>

<script>
import { Bar, Line, Pie, Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, LineElement, PointElement, ArcElement, CategoryScale, LinearScale, RadialLinearScale } from 'chart.js'
import axios from 'axios'


ChartJS.register(
  Title, Tooltip, Legend, BarElement, LineElement, PointElement, ArcElement, CategoryScale, LinearScale, RadialLinearScale
)

export default {
  components: {
    Bar, Line, Pie, Doughnut
  },
  data() {
    return {
      barChartData: {
        labels: [],
        datasets: []
      },
      pieChartData: {
        labels: [],
        datasets: []
      },
      lineChartData: {
        labels: [],
        datasets: []
      },
      doughnutChartData: {
        labels: [],
        datasets: []
      },
      barChartOptions: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Bar Chart',
            font: {
              size: 16
            }
          },
          legend: {
            position: 'top'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.raw;
              }
            }
          }
        }
      },
      pieChartOptions: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Pie Chart',
            font: {
              size: 16
            }
          },
          legend: {
            position: 'top'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.raw;
              }
            }
          }
        }
      },
      lineChartOptions: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Line Chart',
            font: {
              size: 16
            }
          },
          legend: {
            position: 'top'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.raw;
              }
            }
          }
        }
      },
      doughnutChartOptions: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Doughnut Chart',
            font: {
              size: 16
            }
          },
          legend: {
            position: 'top'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.raw;
              }
            }
          }
        }
      }
    }
  },
  mounted() {
    this.fetchStats();
  },
  methods: {
    async fetchStats() {
      try {
        const [reservationStats, userStats, hebergementStats, chambresStats] = await Promise.all([
          axios.get('http://127.0.0.1:8000/api/reservationstats'),
          axios.get('http://127.0.0.1:8000/api/usersstats'),
          axios.get('http://127.0.0.1:8000/api/hebergementstats'),
          axios.get('http://127.0.0.1:8000/api/chambresstat')
        ]);

        this.updateBarChart(reservationStats.data);
        this.updatePieChart(userStats.data);
        this.updateLineChart(hebergementStats.data);
        this.updateDoughnutChart(chambresStats.data);
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    },
    updateBarChart(data) {
      this.barChartData = {
        labels: data.reservations_by_hebergement.map(item => item.code_hb),
        datasets: [
          {
            label: 'Reservations by Accommodation',
            data: data.reservations_by_hebergement.map(item => item.total),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }
        ]
      };
    },
    updatePieChart(data) {
      this.pieChartData = {
        labels: data.users_by_genre.map(item => item.genre),
        datasets: [
          {
            label: 'Users by Genre',
            data: data.users_by_genre.map(item => item.total),
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
          }
        ]
      };
    },
    updateLineChart(data) {
      this.lineChartData = {
        labels: data.stats_par_hebergement.map(item => item.nom),
        datasets: [
          {
            label: 'Total Rooms by Accommodation',
            data: data.stats_par_hebergement.map(item => item.total_chambres),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 1,
            fill: true
          }
        ]
      };
    },
    updateDoughnutChart(data) {
      this.doughnutChartData = {
        labels: data.stats_par_hebergement.map(item => item.nom),
        datasets: [
          {
            label: 'Available Rooms by Accommodation',
            data: data.stats_par_hebergement.map(item => item.total_chambres_disponibles),
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
          }
        ]
      };
    }
  }
};
</script>

<style>
.charts-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  height: 100vh;
  padding: 16px;
}

.chart {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 16px;
}

.chart-title {
  text-align: center;
  margin-top: 8px;
  font-size: 18px;
}
</style>
