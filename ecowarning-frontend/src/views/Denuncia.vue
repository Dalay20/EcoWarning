<template>
  <div class="denuncia-container">
    <div class="denuncia-main card" v-if="denuncia">
      <div class="denuncia-header">
        <div class="denuncia-tipo">
          #{{ denuncia.id }} — <span>{{ denuncia.tipo }}</span>
          <span class="denuncia-gravedad" :class="denuncia.gravedad">{{ denuncia.gravedad }}</span>
        </div>
        <div class="denuncia-meta">{{ denuncia.ubicacion }} • {{ denuncia.fecha }}</div>
      </div>
      <div class="denuncia-body">
        <p>{{ denuncia.descripcion }}</p>
        <img v-if="denuncia.foto" :src="fotoUrl(denuncia.foto)" class="denuncia-img" />
      </div>
    </div>
    <div class="denuncia-coment card">
      <h3>Comentarios</h3>
      <form class="coment-form" @submit.prevent="agregar">
        <textarea class="input" rows="3" placeholder="Escribe un comentario…" v-model="nuevo"></textarea>
        <div class="coment-btns">
          <button class="btn" :disabled="cargando || !nuevo.trim()">{{ cargando ? 'Enviando…' : 'Agregar comentario' }}</button>
          <RouterLink class="btn ghost" to="/">Volver</RouterLink>
        </div>
      </form>
      <ul class="coment-list">
        <li v-for="c in comentarios" :key="c.id" class="coment-item">
          <div>{{ c.comentario }}</div>
          <small>{{ c.fecha }}</small>
        </li>
        <li v-if="!comentarios || comentarios.length === 0" class="coment-empty">Sin comentarios</li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
.denuncia-container {
  display: flex;
  flex-wrap: wrap;
  gap: 32px;
  max-width: 1000px;
  margin: 0 auto;
  align-items: flex-start;
}
.denuncia-main {
  flex: 2 1 340px;
  min-width: 320px;
  padding: 28px 28px 18px 28px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0,0,0,.07);
}
.denuncia-header {
  margin-bottom: 12px;
}
.denuncia-tipo {
  font-size: 1.2rem;
  font-weight: 600;
  color: #1e293b;
  display: flex;
  align-items: center;
  gap: 10px;
}
.denuncia-tipo span {
  font-weight: 400;
  color: #64748b;
}
.denuncia-gravedad {
  font-size: 0.95em;
  font-weight: 600;
  padding: 2px 10px;
  border-radius: 8px;
  margin-left: 8px;
  background: #f1f5f9;
  color: #334155;
  text-transform: capitalize;
}
.denuncia-gravedad.alta {
  background: #fee2e2;
  color: #b91c1c;
}
.denuncia-gravedad.media {
  background: #fef9c3;
  color: #b45309;
}
.denuncia-gravedad.baja {
  background: #dcfce7;
  color: #15803d;
}
.denuncia-meta {
  font-size: 0.95em;
  color: #64748b;
  margin-bottom: 8px;
}
.denuncia-body {
  margin-top: 10px;
}
.denuncia-img {
  display: block;
  max-width: 100%;
  max-height: 320px;
  border-radius: 12px;
  margin-top: 14px;
  box-shadow: 0 2px 8px rgba(0,0,0,.08);
}
.denuncia-coment {
  flex: 1 1 320px;
  min-width: 280px;
  padding: 24px 20px 18px 20px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0,0,0,.07);
}
.coment-form {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 18px;
}
.coment-btns {
  display: flex;
  gap: 12px;
}
.coment-list {
  list-style: none;
  padding: 0;
  margin: 0;
}
.coment-item {
  padding: 14px 0 10px 0;
  border-bottom: 1px solid #f1f5f9;
  font-size: 1em;
}
.coment-item small {
  display: block;
  color: #64748b;
  font-size: 0.93em;
  margin-top: 2px;
}
.coment-empty {
  opacity: .6;
  padding: 10px 0;
  text-align: center;
}
</style>

<script setup>
import { onMounted, ref } from 'vue'
import api, { UPLOADS_URL } from '../services/api'
import { useRoute } from 'vue-router'

function fotoUrl(foto) {
  if (!foto) return null
  if (/^https?:\/\//.test(foto)) return foto
  if (foto.startsWith('/uploads/')) return UPLOADS_URL + foto.replace('/uploads/', '')
  return foto
}

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