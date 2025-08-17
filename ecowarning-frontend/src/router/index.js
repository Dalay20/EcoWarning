import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import NuevaDenuncia from '../views/NuevaDenuncia.vue'
import Denuncia from '../views/Denuncia.vue'
import Reportes from '../views/Reportes.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/nueva', name: 'nueva', component: NuevaDenuncia },
  { path: '/denuncia/:id', name: 'denuncia', component: Denuncia, props: true },
  { path: '/reportes', name: 'reportes', component: Reportes },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})