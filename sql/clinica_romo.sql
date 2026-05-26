-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS clinica_romo;
USE clinica_romo;

-- Tabla de mensajes de contacto
CREATE TABLE IF NOT EXISTS mensajes_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN DEFAULT FALSE
);

-- Tabla de administradores
CREATE TABLE IF NOT EXISTS administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar administrador por defecto
-- Usuario: admin
-- Contraseña: admin123
INSERT IGNORE INTO administradores (usuario, password, email, nombre_completo) 
VALUES ('admin', MD5('admin123'), 'admin@clinicadentalromo.com', 'Administrador Principal');

-- Verificar que se inserto correctamente
SELECT * FROM administradores;

-- Tabla de servicios
CREATE TABLE IF NOT EXISTS servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    icono VARCHAR(50) DEFAULT 'fas fa-tooth',
    orden INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar servicios
INSERT INTO servicios (nombre, descripcion, icono, orden) VALUES
('Ortodoncias', 'Mediante la aplicación de fuerzas para realizar pequeños movimientos en los dientes y los huesos maxilares, la ortodoncia nos sirve para asegurar una correcta posición de los dientes y un mejor funcionamiento de la mandíbula.', 'fas fa-teeth-open', 1),
('Puentes', 'Un puente dental es una prótesis parcial fija. Gracias su colocación, los pacientes que han perdido más de una pieza pueden ver restablecida tanto la estética como la funcionalidad de su sonrisa.', 'fas fa-tooth', 2),
('Implantes', 'Un implante es el sustituto artificial de la raíz de un diente perdido. Normalmente tiene forma roscada y es de titanio.', 'fas fa-tooth', 3),
('Empastes', 'También llamado obturación, un empaste es la restauración de un diente roto o cariado con materiales estéticos.', 'fas fa-fill-drip', 4),
('Blanqueamientos dentales', 'Es un tratamiento con el cuál conseguiremos aclarar el color de los dientes varios tonos. El tratamiento puede realizarse en la clínica, en casa o combinando los dos.', 'fas fa-smile', 5),
('Tratamientos periodontales', 'Los tratamientos periodontales se realizan para prevenir o curar la retracción de las encías, la pérdida de hueso y evitar la caída de los dientes.', 'fas fa-teeth', 6),
('PADI', 'El Departamento de Salud y Osakidetza, con la colaboración de un extenso cuadro de dentistas concertados, aseguran de forma gratuita con el PADI la atención dental a todos los niños y niñas desde los 7 a 15 años.', 'fas fa-child', 7);