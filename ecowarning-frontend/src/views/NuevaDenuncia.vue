<template>
  <form class="card grid" style="grid-template-columns: 1fr; max-width: 720px;" @submit.prevent="enviar">
    <div class="grid" style="grid-template-columns: repeat(2, minmax(0, 1fr));">
      <div>
        <label class="label">Tipo</label>
        <select v-model="form.tipo">
          <option disabled value="">Selecciona…</option>
          <option value="quema">Quema</option>
          <option value="contaminacion">Contaminación</option>
          <option value="mineria">Minería ilegal</option>
        </select>
      </div>
      <div>
        <label class="label">Gravedad</label>
        <select v-model="form.gravedad">
          <option disabled value="">Selecciona…</option>
          <option value="baja">Baja</option>
          <option value="media">Media</option>
          <option value="alta">Alta</option>
        </select>
      </div>
    </div>

    <div>
      <label class="label">Ubicación (lat,lng)</label>
      <input class="input" placeholder="-0.1807,-78.4678" v-model="form.ubicacion" />
      <small style="opacity:.7">Ej: -1.8312,-78.1834 (Ecuador). Más adelante podemos elegir en el mapa.</small>
    </div>

    <div>
      <label class="label">Descripción</label>
      <textarea rows="4" v-model="form.descripcion" placeholder="Describe el incidente…"></textarea>
    </div>

    <div>
      <label class="label">Foto (opcional)</label>
      <input class="input" type="file" accept="image/*" @change="onFile" />
    </div>

    <div class="grid" style="grid-template-columns: auto auto; gap:12px;">
      <button class="btn" type="submit" :disabled="cargando">{{ cargando ? 'Guardando…' : 'Guardar denuncia' }}</button>
      <RouterLink class="btn ghost" to="/">Cancelar</RouterLink>
    </div>

    <p v-if="msg" :style="{ color: ok ? 'green' : 'crimson' }">{{ msg }}</p>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import api from '../services/api'

const form = ref({ tipo:'', gravedad:'', ubicacion:'', descripcion:'' })
const file = ref(null)
const cargando = ref(false)
const msg = ref('')
const ok = ref(false)

function onFile(e) { file.value = e.target.files?.[0] || null }

async function enviar() {
  msg.value = ''
  ok.value = false
  cargando.value = true
  try {
    const fd = new FormData()
    fd.append('tipo', form.value.tipo)
    fd.append('ubicacion', form.value.ubicacion)
    fd.append('descripcion', form.value.descripcion)
    fd.append('gravedad', form.value.gravedad)
    if (file.value) fd.append('foto', file.value)

    const { data } = await api.post('/guardar.php', fd, { headers: { 'Content-Type': 'multipart/form-data' } })
    if (data?.ok) {
      ok.value = true
      msg.value = 'Denuncia registrada (ID ' + data.id + ')'
      // Limpieza básica
      form.value = { tipo:'', gravedad:'', ubicacion:'', descripcion:'' }
      file.value = null
    } else {
      msg.value = data?.error || 'No se pudo guardar'
    }
  } catch (e) {
    msg.value = e?.response?.data?.error || e.message
  } finally {
    cargando.value = false
  }
}
</script>