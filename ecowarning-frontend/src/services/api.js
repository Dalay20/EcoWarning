import axios from 'axios'

const baseURL = import.meta.env.VITE_API_BASE || '/api'

export const UPLOADS_URL = 'http://localhost:8000/uploads/'

const api = axios.create({ baseURL })

export default api

// Helper para query params limpios
export function makeQuery(params) {
  const p = new URLSearchParams()
  Object.entries(params || {}).forEach(([k, v]) => {
    if (v !== undefined && v !== null && String(v).trim() !== '') p.append(k, v)
  })
  return p.toString()
}