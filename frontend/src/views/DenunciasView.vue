<template>
  <div>
    <h1>EcoWarning! - Denuncias</h1>
    <form @submit.prevent="fetchDenuncias">
      <label>Tipo:</label>
      <select v-model="filtros.tipo">
        <option value="">Todos</option>
        <option value="quema">Quema</option>
        <option value="contaminacion">Contaminación</option>
        <option value="mineria">Minería ilegal</option>
      </select>
      <label>Fecha:</label>
      <input type="date" v-model="filtros.fecha" />
      <label>Gravedad:</label>
      <select v-model="filtros.gravedad">
        <option value="">Todas</option>
        <option value="baja">Baja</option>
        <option value="media">Media</option>
        <option value="alta">Alta</option>
      </select>
      <button type="submit">Filtrar</button>
      <button type="button" @click="resetFiltros">Quitar filtros</button>
    </form>
    <table v-if="denuncias.length">
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Ubicación</th>
          <th>Descripción</th>
          <th>Fecha</th>
          <th>Foto</th>
          <th>Gravedad</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="d in denuncias" :key="d.id">
          <td>{{ d.tipo }}</td>
          <td>{{ d.ubicacion }}</td>
          <td>{{ d.descripcion }}</td>
          <td>{{ d.fecha }}</td>
          <td>
            <img v-if="d.foto" :src="d.foto" width="80" />
            <span v-else>Sin foto</span>
          </td>
          <td>{{ d.gravedad }}</td>
        </tr>
      </tbody>
    </table>
    <p v-else>No hay denuncias para mostrar.</p>
  </div>
  <div>
    
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const denuncias = ref([])
const filtros = ref({ tipo: '', fecha: '', gravedad: '' })

const fetchDenuncias = async () => {
  const params = new URLSearchParams(filtros.value).toString()
  const res = await fetch(`http://localhost/EcoWarning/backend/api/denuncias.php?${params}`)
  denuncias.value = await res.json()
}

const resetFiltros = () => {
  filtros.value = { tipo: '', fecha: '', gravedad: '' }
  fetchDenuncias()
}

onMounted(fetchDenuncias)
</script>