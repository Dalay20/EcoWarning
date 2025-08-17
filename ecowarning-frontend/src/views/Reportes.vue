<template>
  <div class="grid" style="grid-template-columns: 1fr; gap: 16px;">
    <div class="card">
      <h3 style="margin:0 0 8px 0;">Denuncias por tipo</h3>
      <canvas id="chartTipo" height="260"></canvas>
    </div>
    <div class="card">
      <h3 style="margin:0 0 8px 0;">Denuncias por gravedad</h3>
      <canvas id="chartGravedad" height="260"></canvas>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import api from '../services/api'
import { Chart, BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend, ArcElement } from 'chart.js'

Chart.register(BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend, ArcElement)

let chart1, chart2

onMounted(async () => {
  const { data } = await api.get('/reporte.php')
  const ctx1 = document.getElementById('chartTipo')
  const ctx2 = document.getElementById('chartGravedad')

  if (data?.ok) {
    chart1 = new Chart(ctx1, {
      type: 'bar',
      data: {
        labels: data.por_tipo.labels,
        datasets: [{ label: 'Incidentes', data: data.por_tipo.values }]
      },
      options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    })

    chart2 = new Chart(ctx2, {
      type: 'pie',
      data: {
        labels: data.por_gravedad.labels,
        datasets: [{ label: 'Incidentes', data: data.por_gravedad.values }]
      },
      options: { responsive: true }
    })
  }
})
</script>