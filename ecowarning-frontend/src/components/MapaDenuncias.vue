<template>
  <div ref="mapEl" style="height: 540px; width: 100%; border-radius: 16px; overflow: hidden;" class="card"></div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import { UPLOADS_URL } from '../services/api'

// Fix de íconos en Vite (URL absolutas para evitar problemas con Vite)
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconUrl: '/leaflet/marker-icon.png',
  iconRetinaUrl: '/leaflet/marker-icon-2x.png',
  shadowUrl: '/leaflet/marker-shadow.png'
})

const props = defineProps({
  denuncias: { type: Array, default: () => [] }
})

const mapEl = ref(null)
let map, markersLayer

onMounted(() => {
  console.log('MapaDenuncias onMounted')
  map = L.map(mapEl.value).setView([-1.8312, -78.1834], 6) // Ecuador
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map)
  markersLayer = L.layerGroup().addTo(map)
  renderMarkers()
})

watch(() => props.denuncias, renderMarkers, { deep: true })

function fotoUrl(foto) {
  if (!foto) return null
  if (/^https?:\/\//.test(foto)) return foto
  if (foto.startsWith('/uploads/')) return UPLOADS_URL + foto.replace('/uploads/', '')
  return foto
}

function renderMarkers() {
  L.marker([-0.18, -78.46]).addTo(map).bindPopup('Pin de prueba')
  console.log('RenderesMarkers onMounted')
  if (!markersLayer) return
  markersLayer.clearLayers()
  props.denuncias.forEach(d => {
    if (!d.ubicacion) return
    // Limpiar espacios y validar formato
    const partes = String(d.ubicacion).split(',').map(s => s.trim())
    if (partes.length !== 2) return
    const lat = Number(partes[0])
    const lng = Number(partes[1])
    if (!Number.isFinite(lat) || !Number.isFinite(lng)) return
    // Solo mostrar popup si hay tipo y gravedad
    let popup = ''
    if (d.tipo || d.gravedad) {
      popup = `<b>${d.tipo || ''}</b> ${d.gravedad ? '(' + d.gravedad + ')' : ''}`
    }
    if (d.descripcion) popup += `<br>${d.descripcion}`
    if (d.foto) popup += `<br><img src="${fotoUrl(d.foto)}" style="max-width:160px; border-radius:8px; margin-top:6px;">`
    if (d.id) popup += `<br><a href="/denuncia/${d.id}">Ver comentarios</a>`
    L.marker([lat, lng]).bindPopup(popup).addTo(markersLayer)
  })
}
</script>