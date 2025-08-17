<template>
  <form class="card grid" @submit.prevent="emitir">
    <div class="grid" style="grid-template-columns: repeat(4, minmax(0, 1fr));">
      <div>
        <label class="label">Tipo</label>
        <select v-model="local.tipo">
          <option value="">Todos</option>
          <option value="quema">Quema</option>
          <option value="contaminacion">Contaminación</option>
          <option value="mineria">Minería ilegal</option>
        </select>
      </div>
      <div>
        <label class="label">Fecha</label>
        <input class="input" type="date" v-model="local.fecha" />
      </div>
      <div>
        <label class="label">Gravedad</label>
        <select v-model="local.gravedad">
          <option value="">Todas</option>
          <option value="baja">Baja</option>
          <option value="media">Media</option>
          <option value="alta">Alta</option>
        </select>
      </div>
      <div class="grid" style="align-items:end">
        <button class="btn" type="submit">Aplicar filtros</button>
      </div>
    </div>
  </form>
</template>

<script setup>
import { reactive, watch } from 'vue'

const props = defineProps({
  modelValue: { type: Object, default: () => ({ tipo:'', fecha:'', gravedad:'' }) }
})

const emit = defineEmits(['update:modelValue', 'submit'])

const local = reactive({
  tipo: props.modelValue.tipo || '',
  fecha: props.modelValue.fecha || '',
  gravedad: props.modelValue.gravedad || ''
})

watch(local, () => emit('update:modelValue', { ...local }))

function emitir() { emit('submit') }
</script>