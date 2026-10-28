# Hills Snacks

Sitio web tipo delivery de comida a domicilio para el fraccionamiento Colinas de Tonalá (PHP + MySQL).

## Cómo ejecutarlo (XAMPP / Laragon)

1. Copia la carpeta del proyecto dentro de `htdocs` (XAMPP) y enciende **Apache** y **MySQL**.
2. En phpMyAdmin, pestaña **Importar**, selecciona `database/hills_snacks.sql`.
   (Crea la base `hills_snacks` con negocios, productos y cuentas de prueba.)
3. Abre `http://localhost/<nombre-de-la-carpeta>/index.php`.

Sin XAMPP, desde la carpeta del proyecto: `php -S localhost:8080` y abre `http://localhost:8080`.

## Cuentas de prueba

| Rol     | Correo                     | Contraseña    |
|---------|----------------------------|---------------|
| Admin   | admin@hillssnacks.test     | Admin123!     |
| Cliente | cliente@hillssnacks.test   | Cliente123!   |

## Qué funciona

**Cliente**
- Categorías de comida → negocios de la categoría → productos del negocio.
- Agregar productos al carrito (con cantidad), subir / bajar cantidad, eliminar, vaciar. El carrito se guarda en el navegador y muestra el contador y el total.
- Un pedido es de un solo negocio (si mezclas, el sitio pregunta si quieres empezar uno nuevo).
- Confirmar pedido con pago en efectivo (o PayPal si hay internet). Los precios se calculan en el servidor.

**Administrador** (`Panel admin`)
- Pedidos recibidos y cambio de estado (Pendiente / Completado / Cancelado).
- Historial de órdenes, catálogo de productos e inventario (alta de productos y activar / desactivar).

## Pendiente

- Registro con verificación por correo (requiere configurar `config/MailService.php`).
- Calificaciones de negocios.
- Contraseñas y claves fuera del código (variables de entorno).
