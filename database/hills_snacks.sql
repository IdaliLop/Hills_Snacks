-- ============================================================
-- Hills Snacks - esquema de base de datos + datos de ejemplo
-- Importar en phpMyAdmin (pestaña "Importar") o con:
--   mysql -u root < database/hills_snacks.sql
-- Cuentas de demostración (contraseñas en la sección de abajo):
--   Admin   : admin@hillssnacks.test   / Admin123!
--   Cliente : cliente@hillssnacks.test / Cliente123!
-- ============================================================

-- Forzar UTF-8 al importar (si no, el nombre de la tabla `dueño` se guarda mal en algunos equipos)
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS hills_snacks CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE hills_snacks;

DROP TABLE IF EXISTS pedido_detalle;
DROP TABLE IF EXISTS pedido;
DROP TABLE IF EXISTS producto;
DROP TABLE IF EXISTS negocio;
DROP TABLE IF EXISTS `dueño`;
DROP TABLE IF EXISTS usuario_cliente;

-- ---------- Usuarios ----------
CREATE TABLE `dueño` (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_D         VARCHAR(80)  NOT NULL,
    Apellido_D       VARCHAR(80)  NOT NULL,
    Pass_D           VARCHAR(255) NOT NULL,
    Telefono_D       VARCHAR(20),
    Correo_D         VARCHAR(120) NOT NULL UNIQUE,
    token_validacion VARCHAR(64),
    validado         TINYINT(1)   NOT NULL DEFAULT 0
);

CREATE TABLE usuario_cliente (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_UC        VARCHAR(80)  NOT NULL,
    Apellido_UC      VARCHAR(80)  NOT NULL,
    Pass_UC          VARCHAR(255) NOT NULL,
    Telefono_UC      VARCHAR(20),
    Domicilio_UC     VARCHAR(200),
    Correo_UC        VARCHAR(120) NOT NULL UNIQUE,
    token_validacion VARCHAR(64),
    validado         TINYINT(1)   NOT NULL DEFAULT 0
);

-- ---------- Negocios y productos ----------
CREATE TABLE negocio (
    IdNegocio_N  INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_N     VARCHAR(100) NOT NULL,
    Direccion_N  VARCHAR(200),
    Telefono_N   VARCHAR(20),
    Tipo_N       VARCHAR(40)  NOT NULL,   -- Hamburguesas, Alitas, Chilaquiles, Pizza, Pollo, Cenaduria, Tacos, Postres
    Tipo_Envio   VARCHAR(20)  NOT NULL DEFAULT 'Domicilio',
    Imagen_N     VARCHAR(255)
);

CREATE TABLE producto (
    IdProducto_P     INT AUTO_INCREMENT PRIMARY KEY,
    IdNegocio_N      INT           NOT NULL,
    Nombre_P         VARCHAR(100)  NOT NULL,
    Precio_P         DECIMAL(8,2)  NOT NULL,
    Disponibilidad_P VARCHAR(10)   NOT NULL DEFAULT 'Activo',   -- Activo / Inactivo
    Imagen_P         VARCHAR(255),
    FOREIGN KEY (IdNegocio_N) REFERENCES negocio(IdNegocio_N) ON DELETE CASCADE
);

-- ---------- Pedidos ----------
CREATE TABLE pedido (
    IdPedido         INT AUTO_INCREMENT PRIMARY KEY,
    IdNegocio_N      INT           NOT NULL,
    id_cliente       INT           NULL,             -- NULL si compró sin iniciar sesión
    Nombre_Cliente   VARCHAR(120)  NOT NULL,
    Telefono_Cliente VARCHAR(20)   NOT NULL,
    Direccion_Entrega VARCHAR(200) NOT NULL,
    Total            DECIMAL(10,2) NOT NULL,
    Metodo_Pago      VARCHAR(20)   NOT NULL DEFAULT 'Efectivo',
    Referencia_Pago  VARCHAR(80)   NULL,
    Estado           VARCHAR(15)   NOT NULL DEFAULT 'Pendiente',  -- Pendiente / Completado / Cancelado
    Fecha_Creacion   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Fecha_Entrega    DATETIME      NULL,
    FOREIGN KEY (IdNegocio_N) REFERENCES negocio(IdNegocio_N)
);

CREATE TABLE pedido_detalle (
    IdDetalle    INT AUTO_INCREMENT PRIMARY KEY,
    IdPedido     INT           NOT NULL,
    IdProducto_P INT           NOT NULL,
    Nombre_P     VARCHAR(100)  NOT NULL,   -- se guarda el nombre y precio del momento de la compra
    Precio_P     DECIMAL(8,2)  NOT NULL,
    Cantidad     INT           NOT NULL,
    FOREIGN KEY (IdPedido) REFERENCES pedido(IdPedido) ON DELETE CASCADE
);

-- ============================================================
-- DATOS DE EJEMPLO (negocios ficticios; reemplázalos por los reales)
-- ============================================================

-- Cuentas demo (contraseñas guardadas con password_hash)
INSERT INTO `dueño` (Nombre_D, Apellido_D, Pass_D, Telefono_D, Correo_D, validado) VALUES
('Admin', 'Demo', '$2y$10$glVLVKR4yUec6GD7zptjR./AYsfOB.l63ePItuETRFPQ7KnYWE5iC', '3300000000', 'admin@hillssnacks.test', 1);

INSERT INTO usuario_cliente (Nombre_UC, Apellido_UC, Pass_UC, Telefono_UC, Domicilio_UC, Correo_UC, validado) VALUES
('Cliente', 'Demo', '$2y$10$OnELmkBlH3ZI8ZK23Jw.iuYJerScVVMGWatHy0st.rslWHHIr9cdC', '3311111111', 'Calle Ejemplo 123, Colinas de Tonalá', 'cliente@hillssnacks.test', 1);

INSERT INTO negocio (IdNegocio_N, Nombre_N, Direccion_N, Telefono_N, Tipo_N, Tipo_Envio, Imagen_N) VALUES
(1, 'Burger Colinas',        'Calle Alcatraz 10',  '3312345601', 'Hamburguesas', 'Domicilio', 'Util/img/hamburguesa.jpg'),
(2, 'Alitas Tonalá',         'Calle Cóndor 22',    '3312345602', 'Alitas',       'Domicilio', 'Util/img/alitas.jpg'),
(3, 'Chilaquiles Doña Mary', 'Calle Gorrión 5',    '3312345603', 'Chilaquiles',  'Domicilio', 'Util/img/chilaquiles.jpg'),
(4, 'Pizzería La Colina',    'Calle Águila 31',    '3312345604', 'Pizza',        'Ambos',     'Util/img/pizzasEmi.png'),
(5, 'Pollo Dorado',          'Calle Halcón 8',     '3312345605', 'Pollo',        'Domicilio', 'Util/img/pollo2.jpg'),
(6, 'Cenaduría La Esquina',  'Calle Colibrí 14',   '3312345606', 'Cenaduria',    'Domicilio', 'Util/img/cenaduria.jpg'),
(7, 'Tacos El Güero',        'Calle Búho 3',       '3312345607', 'Tacos',        'Domicilio', 'Util/img/Tacos.jpg'),
(8, 'Tapioca Sweet',         'Calle Cisne 19',     '3312345608', 'Postres',      'Domicilio', 'Util/img/tapioca.jpeg');

INSERT INTO producto (IdNegocio_N, Nombre_P, Precio_P, Disponibilidad_P, Imagen_P) VALUES
(1, 'Hamburguesa clásica',        75.00, 'Activo',   'Util/img/hamburguesa.jpg'),
(1, 'Hamburguesa de pollo',       80.00, 'Activo',   'Util/img/hamburguesaPollo.png'),
(1, 'Papas a la francesa',        35.00, 'Activo',   'Util/img/producto.png'),
(1, 'Hamburguesa doble (agotada)',110.00,'Inactivo', 'Util/img/hamburguesa.jpg'),
(2, 'Alitas BBQ (10 pzas)',      110.00, 'Activo',   'Util/img/alitas.jpg'),
(2, 'Alitas picosas (10 pzas)',  115.00, 'Activo',   'Util/img/alitas.jpg'),
(2, 'Boneless (300 g)',          105.00, 'Activo',   'Util/img/alitas.jpg'),
(3, 'Chilaquiles verdes',         65.00, 'Activo',   'Util/img/chilaquiles.jpg'),
(3, 'Chilaquiles rojos',          65.00, 'Activo',   'Util/img/chilaquiles.jpg'),
(3, 'Chilaquiles con pollo',      80.00, 'Activo',   'Util/img/chilaquiles.jpg'),
(4, 'Pizza pepperoni grande',    140.00, 'Activo',   'Util/img/pizza.jpg'),
(4, 'Pizza hawaiana grande',     145.00, 'Activo',   'Util/img/pizza.jpg'),
(4, 'Pizza individual',           60.00, 'Activo',   'Util/img/pizzasEmi.png'),
(5, 'Pollo frito 4 piezas',       95.00, 'Activo',   'Util/img/pollo2.jpg'),
(5, 'Pollo frito 8 piezas',      170.00, 'Activo',   'Util/img/pollo2.jpg'),
(6, 'Pozole mediano',             85.00, 'Activo',   'Util/img/cenaduria.jpg'),
(6, 'Tostadas (3 pzas)',          50.00, 'Activo',   'Util/img/cenaduria.jpg'),
(6, 'Enchiladas (5 pzas)',        70.00, 'Activo',   'Util/img/cenaduria.jpg'),
(7, 'Orden de tacos al pastor',   70.00, 'Activo',   'Util/img/Tacos.jpg'),
(7, 'Taco de bistec',             22.00, 'Activo',   'Util/img/Tacos.jpg'),
(7, 'Gringa',                     45.00, 'Activo',   'Util/img/Tacos.jpg'),
(8, 'Tapioca de fresa',           45.00, 'Activo',   'Util/img/tapioca.jpeg'),
(8, 'Tapioca de mango',           45.00, 'Activo',   'Util/img/tapioca.jpeg');

-- Un par de pedidos de ejemplo para que el panel admin no se vea vacío
INSERT INTO pedido (IdPedido, IdNegocio_N, id_cliente, Nombre_Cliente, Telefono_Cliente, Direccion_Entrega, Total, Metodo_Pago, Estado, Fecha_Creacion, Fecha_Entrega) VALUES
(1, 1, 1, 'Cliente Demo', '3311111111', 'Calle Ejemplo 123, Colinas de Tonalá', 185.00, 'Efectivo', 'Completado', NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY + INTERVAL 40 MINUTE),
(2, 1, NULL, 'María López',  '3322222222', 'Calle Prueba 45, Colinas de Tonalá', 110.00, 'PayPal', 'Cancelado', NOW() - INTERVAL 1 DAY, NULL);

INSERT INTO pedido_detalle (IdPedido, IdProducto_P, Nombre_P, Precio_P, Cantidad) VALUES
(1, 1, 'Hamburguesa clásica',  75.00, 2),
(1, 3, 'Papas a la francesa',  35.00, 1),
(2, 1, 'Hamburguesa clásica',  75.00, 1),
(2, 3, 'Papas a la francesa',  35.00, 1);
