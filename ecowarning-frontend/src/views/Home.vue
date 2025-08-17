<template>
  <div class="grid" style="grid-template-columns: 1fr;">
    <FiltersBar v-model="filtros" @submit="cargar" />
    <MapaDenuncias :denuncias="denuncias" />
    <ListaDenuncias :denuncias="denuncias" />
    <div class="card" v-if="resumen">
      <b>Resumen:</b>
      <span style="margin-left:8px">Total: {{ total }}</span>
      <span style="margin-left:8px">Alta: {{ resumen.alta }}</span>
      <span style="margin-left:8px">Media: {{ resumen.media }}</span>
      <span style="margin-left:8px">Baja: {{ resumen.baja }}</span>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api, { makeQuery } from '../services/api'
import FiltersBar from '../components/FiltersBar.vue'
import MapaDenuncias from '../components/MapaDenuncias.vue'
import ListaDenuncias from '../components/ListaDenuncias.vue'

const filtros = ref({ tipo:'', fecha:'', gravedad:'' })
const denuncias = ref([])
const resumen = ref(null)
const total = ref(0)

async function cargar() {
  const qs = makeQuery(filtros.value)
  const { data } = await api.get(`/index.php${qs ? `?${qs}` : ''}`)
  if (data?.ok) {
    denuncias.value = data.denuncias || []
    resumen.value = data.resumen || null
    total.value = data.total || 0
  } else {
    denuncias.value = []
    resumen.value = null
    total.value = 0
  }
}

onMounted(cargar)
</script>