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

