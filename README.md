# EcoWarning! 🌱

**EcoWarning!** es una plataforma ciudadana para reportar incidentes ambientales en Ecuador.  
Permite registrar, visualizar y filtrar denuncias geolocalizadas con evidencia fotográfica y nivel de gravedad.  
Los reportes se muestran en un mapa interactivo y también en tablas filtrables, con estadísticas gráficas.


## 🛠 Herramientas Usadas

- **Backend:** PHP 7+, SQLite3
- **Frontend:** Vue 3, Vite, Vue Router, componentes personalizados
- **Base de datos:** SQLite
- **Otros:** OpenStreetMap con Leaflet.js, Chart.js para gráficos



## 📂 Estructura del Proyecto

```
/backend                       # Backend en PHP (API + SQLite)
│
├── database.db                # Base de datos SQLite
├── database.sql               # Script SQL para recrear la base de datos
├── db.php                     # Conexión a SQLite
├── index.php                  # Página principal (mapa + denuncias)
├── formulario.php             # Formulario para nueva denuncia
├── guardar.php                # Endpoint para guardar denuncias
├── comentario.php             # Endpoint para comentarios
├── reporte.php                # Reportes y estadísticas
├── /uploads                   # Carpeta de imágenes subidas por los usuarios
│   ├── 1756054981_incendio.jpg
│   └── ... (otros archivos .jpg)

/ecowarning-frontend           # Frontend en Vue 3 + Vite
├──/src                        # Código fuente principal
    ├── main.js                # Entrada de la app, monta Vue y router
    ├── App.vue                # Componente raíz
    │
    ├── /components            # Componentes reutilizables
    │   ├── FiltersBar.vue     # Barra de filtros de denuncias
    │   ├── ListaDenuncias.vue # Lista de denuncias
    │   └── MapaDenuncias.vue  # Mapa interactivo con ubicaciones
    │
    ├── /views                 # Vistas (páginas asociadas a rutas)
    │   ├── Home.vue           # Página de inicio
    │   ├── Reportes.vue       # Estadísticas y gráficos
    │   ├── NuevaDenuncia.vue  # Formulario para crear denuncias
    │   └── Denuncia.vue       # Detalle de una denuncia + comentarios
    │
    ├── /router                # Configuración de rutas
    └── /services              # Conexión al backend/API

```

## ⚙ Requisitos Previos

Antes de comenzar asegúrate de tener instalado:

- **Node.js** (versión 16 o superior) 👉 [descargar aquí](https://nodejs.org/)
- **npm** (incluido con Node.js)
- **PHP** (>=7.4) 👉 [descargar aquí](https://www.php.net/downloads)
- **SQLite3** 👉 ya viene instalado en la mayoría de distribuciones (Linux/Mac).  
  Para Windows: [descargar aquí](https://www.sqlite.org/download.html)
- Un navegador web moderno (**Chrome, Firefox, Edge**)

## 🚀 Instalación

### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/Dalay20/ecowarning.git
cd ecowarning
```

### 2️⃣ Configurar el Backend
1. Ir a la carpeta backend/:
```bash
cd backend
```
2. Verifica que tienes SQLite:
```bash 
sqlite3 --version
```
3. Crear la base de datos (si no existe):
```bash  
sqlite3 database.db < database.sql
```
4. Levantar el servidor PHP:
```bash 
php -S localhost:8000
```

### 3️⃣ Configurar el Frontend
1. Ir a la carpeta del frontend:
```bash
cd ecowarning-frontend
```
2. Instalar dependencias:
```bash 
npm install
```
3. Ejecutar en modo desarrollo:
```bash  
npm run dev
```

## ✨ Uso de la Demo
1. Abrir el navegador en `http://localhost:5173` (o la URL que indique Vite).
2. Navegar entre las páginas:
    
    ✅ Registrar denuncia con:
    - Tipo de incidente  
    - Nivel de gravedad (Baja, Media, Alta)
    - Ubicación geográfica  
    - Descripción  
    - Foto  


    ✅ Ver denuncias en un mapa interactivo  
    ✅ Filtrar por tipo, fecha y gravedad  
    ✅ Ver denuncias en tabla debajo del mapa  
    ✅ Agregar y leer comentarios  
    ✅ Ver estadísticas en gráficos (por tipo y gravedad)  
    ✅ Resumen general de denuncias  

## 📍 Coordenadas de ejemplo (Ecuador)

| Ciudad        | Latitud, Longitud        |
|--------------|--------------------------|
| Loja         | `-3.99313, -79.20422`     |
| Galápagos    | `-0.74293, -90.31392`     |


