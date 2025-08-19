<template>
  <div class="card" style="overflow:auto;">
    <table style="width:100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th class="th">Tipo</th>
          <th class="th">Ubicación</th>
          <th class="th">Descripción</th>
          <th class="th">Fecha</th>
          <th class="th">Foto</th>
          <th class="th">Gravedad</th>
          <th class="th">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="d in denuncias" :key="d.id" class="tr">
          <td class="td">{{ d.tipo }}</td>
          <td class="td">{{ d.ubicacion }}</td>
          <td class="td">{{ d.descripcion }}</td>
          <td class="td">{{ d.fecha }}</td>
          <td class="td">
            <img
              v-if="d.foto"
              :src="`${API_URL}${d.foto}`"
              style="width:70px; border-radius:8px;"
            />
            <span v-else>—</span>
          </td>
          <td class="td" :style="{ textTransform: 'capitalize' }">{{ d.gravedad }}</td>
          <td class="td">
            <RouterLink class="btn ghost" :to="`/denuncia/${d.id}`">Comentarios</RouterLink>
          </td>
        </tr>
        <tr v-if="!denuncias || denuncias.length === 0">
          <td class="td" colspan="7" style="text-align:center; padding:18px; opacity:.7;">No hay denuncias</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
const props = defineProps({ denuncias: { type: Array, default: () => [] } })
const API_URL = import.meta.env.VITE_API_URL
</script>

<style scoped>
.th, .td { padding: 10px; border-bottom: 1px solid #f1f5f9; text-align: left; }
.td img { display: block; }
.tr:hover { background: #fafafa; }
</style>
