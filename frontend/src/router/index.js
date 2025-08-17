import { createRouter, createWebHistory } from 'vue-router'
import DenunciasView from '../views/DenunciasView.vue'
import FormularioView from '../views/FormularioView.vue'

const routes = [
  { path: '/', name: 'Denuncias', component: DenunciasView },
  { path: '/nueva', name: 'NuevaDenuncia', component: FormularioView }

]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router