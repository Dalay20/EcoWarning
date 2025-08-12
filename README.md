# EcoWarning! 🌱

**EcoWarning!** es una plataforma ciudadana para reportar incidentes ambientales en Ecuador.  
Permite registrar, visualizar y filtrar denuncias geolocalizadas con evidencia fotográfica y nivel de gravedad.  
Los reportes se muestran en un mapa interactivo y también en tablas filtrables, con estadísticas gráficas.

---

## 📌 Tecnologías

- **Backend:** PHP puro (sin frameworks)
- **Frontend:** HTML, CSS y JavaScript básico
- **Base de datos:** SQLite
- **Mapa:** OpenStreetMap con Leaflet.js
- **Gráficos:** Chart.js
- **Almacenamiento de imágenes:** Carpeta local `/uploads`

---

## 📂 Estructura del Proyecto

```
/ecowarning
│
├── index.php         # Mapa, filtros y listado de denuncias
├── formulario.php    # Formulario para registrar nueva denuncia
├── guardar.php       # Procesa y guarda denuncias
├── comentario.php    # Agrega y muestra comentarios
├── reporte.php       # Estadísticas con Chart.js
├── db.php            # Conexión a la base de datos SQLite
├── /uploads          # Carpeta de imágenes subidas
├── /css              # Estilos CSS
└── /js               # Scripts JavaScript
```

---

## ⚙ Instalación y Uso

### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/usuario/ecowarning.git
cd ecowarning
```

### 2️⃣ Crear base de datos SQLite
Ejecutar en la terminal:
```bash
sqlite3 ecowarning.db
```
Dentro de SQLite, crear tablas:
```sql
CREATE TABLE denuncias (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tipo TEXT NOT NULL,
    ubicacion TEXT NOT NULL,
    descripcion TEXT,
    foto TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    gravedad TEXT
);

CREATE TABLE comentarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_denuncia INTEGER NOT NULL,
    comentario TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(id_denuncia) REFERENCES denuncias(id)
);
.exit
```

### 3️⃣ Iniciar servidor local de PHP
```bash
php -S 0.0.0.0:8000
```
Abrir en el navegador:
```
http://localhost:8000
```

---

## 📍 Coordenadas de ejemplo (Ecuador)

| Ciudad        | Latitud, Longitud        |
|--------------|--------------------------|
| Quito        | `-0.180653, -78.467834`   |
| Guayaquil    | `-2.189412, -79.889066`   |
| Cuenca       | `-2.900128, -79.005896`   |
| Loja         | `-3.99313, -79.20422`     |
| Galápagos    | `-0.74293, -90.31392`     |

---

## ✨ Funcionalidades

✅ Registrar denuncia con:
- Tipo de incidente  
- Ubicación geográfica  
- Descripción  
- Foto  
- Nivel de gravedad (Baja, Media, Alta)

✅ Ver denuncias en un mapa interactivo  
✅ Filtrar por tipo, fecha y gravedad  
✅ Ver denuncias en tabla debajo del mapa  
✅ Agregar y leer comentarios  
✅ Ver estadísticas en gráficos (por tipo y gravedad)  
✅ Resumen general de denuncias  

---
