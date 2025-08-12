-- Tabla principal de denuncias
CREATE TABLE denuncias (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tipo TEXT NOT NULL,
    ubicacion TEXT NOT NULL, -- puede ser lat,long
    descripcion TEXT,
    foto TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de comentarios
CREATE TABLE comentarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_denuncia INTEGER NOT NULL,
    comentario TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(id_denuncia) REFERENCES denuncias(id)
);
