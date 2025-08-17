<template>
  <div>
    <h1>Nueva Denuncia</h1>
    <form @submit.prevent="enviarDenuncia" enctype="multipart/form-data">
      <label>Tipo de incidente:</label>
      <select v-model="form.tipo" required>
        <option value="quema">Quema</option>
        <option value="contaminacion">Contaminación</option>
        <option value="mineria">Minería ilegal</option>
      </select>
      <br>

      <label>Ubicación (lat,long):</label>
      <input type="text" v-model="form.ubicacion" required>
      <br>

      <label>Descripción:</label>
      <textarea v-model="form.descripcion"></textarea>
      <br>

      <label>Foto:</label>
      <input type="file" @change="onFileChange">
      <br>

      <label>Nivel de gravedad:</label>
      <select v-model="form.gravedad" required>
        <option value="baja">Baja</option>
        <option value="media">Media</option>
        <option value="alta">Alta</option>
      </select>
      <br>

      <button type="submit">Enviar denuncia</button>
      <button type="button" @click="volver">Cancelar y volver al mapa</button>
    </form>
    <p v-if="mensaje">{{ mensaje }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const form = ref({
  tipo: 'quema',
  ubicacion: '',
  descripcion: '',
  gravedad: 'baja',
  foto: null
})
const mensaje = ref('')

function onFileChange(e) {
  form.value.foto = e.target.files[0]
}

async function enviarDenuncia() {
  const formData = new FormData()
  formData.append('tipo', form.value.tipo)
  formData.append('ubicacion', form.value.ubicacion)
  formData.append('descripcion', form.value.descripcion)
  formData.append('gravedad', form.value.gravedad)
  if (form.value.foto) {
    formData.append('foto', form.value.foto)
  }

  const res = await fetch('http://localhost:8000/guardar.php', {
    method: 'POST',
    body: formData
  })
  const data = await res.json()
  if (data.success) {
    mensaje.value = '¡Denuncia enviada correctamente!'
    setTimeout(() => router.push('/'), 1500)
  } else {
    mensaje.value = data.error || 'Error al enviar denuncia'
  }
}

function volver() {
  router.push('/')
}
</script>