<template>
  <div class="grid" style="grid-template-columns: 1fr; gap: 16px; max-width: 900px;">
    <div class="card" v-if="denuncia">
      <h2 style="margin:0 0 8px 0;">Denuncia #{{ denuncia.id }} — {{ denuncia.tipo }} ({{ denuncia.gravedad }})</h2>
      <div style="opacity:.8; font-size: 14px;">{{ denuncia.ubicacion }} • {{ denuncia.fecha }}</div>
      <p style="margin-top: 10px;">{{ denuncia.descripcion }}</p>
      <img v-if="denuncia.foto" :src="denuncia.foto" style="max-width: 320px; border-radius: 12px; margin-top: 8px;" />
    </div>

    <div class="card">
      <h3 style="margin-top:0;">Comentarios</h3>
      <form class="grid" @submit.prevent="agregar">
        <textarea class="input" rows="3" placeholder="Escribe un comentario…" v-model="nuevo"></textarea>
        <div style="display:flex; gap: 12px;">
          <button class="btn" :disabled="cargando || !nuevo.trim()">{{ cargando ? 'Enviando…' : 'Agregar comentario' }}</button>
          <RouterLink class="btn ghost" to="/">Volver</RouterLink>
        </div>
      </form>
      <ul style="list-style:none; padding:0; margin-top: 16px;">
        <li v-for="c in comentarios" :key="c.id" style="padding: 12px 0; border-bottom: 1px solid #eee;">
          <div>{{ c.comentario }}</div>
          <small style="opacity:.7;">{{ c.fecha }}</small>
        </li>
        <li v-if="!comentarios || comentarios.length === 0" style="opacity:.6; padding:8px 0;">Sin comentarios</li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import api from '../services/api'
import { useRoute } from 'vue-router'

const route = useRoute()
const id = Number(route.params.id)

const denuncia = ref(null)
const comentarios = ref([])
const nuevo = ref('')
const cargando = ref(false)

async function cargar() {
  const { data } = await api.get(`/comentario.php?id=${id}`)
  if (data?.ok) {
    denuncia.value = data.denuncia
    comentarios.value = data.comentarios || []
  }
}

async function agregar() {
  if (!nuevo.value.trim()) return
  try {
    cargando.value = true
    await api.post('/comentario.php', { id_denuncia: id, comentario: nuevo.value })
    nuevo.value = ''
    await cargar()
  } finally {
    cargando.value = false
  }
}

onMounted(cargar)
</script>