<template>
  <div
    ref="mapEl"
    style="height: 540px; width: 100%; border-radius: 16px; overflow: hidden;"
    class="card"
  ></div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import L from 'leaflet'

// Fix de íconos en Vite
const iconUrl = 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png'
const shadowUrl = 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
L.Icon.Default.mergeOptions({ iconUrl, shadowUrl })

// 🔑 URL del backend desde .env
const API_URL = import.meta.env.VITE_API_URL

const props = defineProps({
  denuncias: { type: Array, default: () => [] }
})

const mapEl = ref(null)
let map, markersLayer

onMounted(() => {
  map = L.map(mapEl.value).setView([-1.8312, -78.1834], 6) // Ecuador
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18
  }).addTo(map)
  markersLayer = L.layerGroup().addTo(map)
  renderMarkers()
})

watch(() => props.denuncias, renderMarkers, { deep: true })

function renderMarkers() {
  if (!markersLayer) return
  markersLayer.clearLayers()
  props.denuncias.forEach(d => {
    if (!d.ubicacion) return
    const [lat, lng] = String(d.ubicacion).split(',').map(Number)
    if (Number.isFinite(lat) && Number.isFinite(lng)) {
      const popup = `
        <b>${d.tipo}</b> (${d.gravedad})<br>
        ${d.descripcion || ''}
        ${
          d.foto
            ? `<br><img src="${API_URL}${d.foto}" style="max-width:160px; border-radius:8px; margin-top:6px;">`
            : ''
        }
        ${d.id ? `<br><a href="/denuncia/${d.id}">Ver comentarios</a>` : ''}
      `
      L.marker([lat, lng]).bindPopup(popup).addTo(markersLayer)
    }
  })
}
</script>
