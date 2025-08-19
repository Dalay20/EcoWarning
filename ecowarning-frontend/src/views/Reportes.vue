<template>
  <div class="charts-grid">
    <div class="card chart-card">
      <h3>Denuncias por tipo</h3>
      <canvas id="chartTipo" class="chart-canvas"></canvas>
    </div>

    <div class="card chart-card">
      <h3>Denuncias por gravedad</h3>
      <canvas id="chartGravedad" class="chart-canvas"></canvas>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue'
import api from '../services/api'
import { Chart, registerables } from 'chart.js'

// Registrar todos los tipos de gráficos
Chart.register(...registerables)

let chart1 = null
let chart2 = null
const msg = ref('')

function destroyCharts () {
  if (chart1) { chart1.destroy(); chart1 = null }
  if (chart2) { chart2.destroy(); chart2 = null }
}

onMounted(async () => {
  try {
    const res = await api.get('/reporte.php')
    const data = res?.data
    console.log('Reporte.php response:', data)

    if (!data?.ok) {
      throw new Error(data?.detalle || data?.error || 'Respuesta inválida del servidor')
    }
    if (data.vacio) {
      msg.value = 'No hay denuncias registradas en los últimos 7 días.'
      return
    }

    const ctx1 = document.getElementById('chartTipo')?.getContext('2d')
    const ctx2 = document.getElementById('chartGravedad')?.getContext('2d')
    if (!ctx1 || !ctx2) return

    destroyCharts()

    chart1 = new Chart(ctx1, {
      type: 'bar',
      data: {
        labels: data.por_tipo.labels || [],
        datasets: [{
          label: 'Incidentes',
          data: data.por_tipo.values || [],
          backgroundColor: '#4e79a7'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
        datasets: { bar: { maxBarThickness: 28, borderRadius: 6 } }
      }
    })

    chart2 = new Chart(ctx2, {
      type: 'pie',
      data: {
        labels: data.por_gravedad.labels || [],
        datasets: [{
          label: 'Incidentes',
          data: data.por_gravedad.values || [],
          backgroundColor: [
            '#4e79a7', '#f28e2b', '#e15759',
            '#76b7b2', '#59a14f', '#edc949'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } },
        radius: '85%' // controla el tamaño del pastel
      }
    })
  } catch (e) {
    const detalle = e?.response?.data?.detalle || e?.message || 'Error al cargar el reporte.'
    msg.value = detalle
    console.error('Reporte error:', e?.response?.data || e)
  }
})

onBeforeUnmount(destroyCharts)
</script>

<style scoped>
.charts-grid {
  display: grid;
  gap: 16px;
  grid-template-columns: 1fr;        /* Una columna en móvil */
  max-width: 1000px;                 /* Centrado y con ancho máximo */
  margin: 0 auto;
}
@media (min-width: 768px) {
  .charts-grid {
    grid-template-columns: 1fr 1fr;  /* Dos columnas en desktop */
  }
}

.chart-card {
  height: 320px;                     /* Tamaño normal para gráficos */
  padding: 12px;
  position: relative;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  border-radius: 8px;
  background: #fff;
}

.chart-card h3 {
  margin: 0 0 8px 0;
  font-size: 16px;
}

.chart-canvas {
  width: 100% !important;
  height: calc(100% - 28px) !important; /* resto espacio para el título */
  display: block;
}
</style>
