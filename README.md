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
- Registro e inicio de sesión (con aviso de correo duplicado, contraseña corta, etc.), perfil con edición de datos y cambio de contraseña.
- Categorías de comida → negocios → productos del negocio.
- Carrito: agregar con cantidad, subir / bajar cantidad, eliminar, vaciar; contador y total. Se guarda en el navegador.
- Un pedido es de un solo negocio (si mezclas, el sitio pregunta si quieres empezar uno nuevo).
- Confirmar pedido con pago en efectivo (o PayPal si hay internet). Los precios se calculan en el servidor.

**Dueño / Administrador**
- Registro de dueño y de negocio (con imagen).
- Pedidos recibidos y cambio de estado (Completado / Cancelado), historial con filtros y descarga en CSV.
- Catálogo, inventario (agregar, **editar**, activar / desactivar productos), "Mi cuenta" (editar datos y contraseña) y centro de ayuda.

## Correo de verificación (opcional)

Al registrarse se intenta mandar un correo para validar la cuenta. Para activarlo:
1. `composer install` en la carpeta del proyecto.
2. Copia `config/mail.example.php` como `config/mail.local.php` y escribe tu correo de Gmail y su contraseña de aplicación.

Si el correo no está configurado o no hay internet, **la cuenta se activa sola** y el registro funciona igual.
`config/mail.local.php` no se sube a GitHub (está en `.gitignore`).

## Pendiente

- Calificaciones de negocios.
- Relacionar cada negocio con su dueño (hoy todos los administradores ven todos los negocios).
- Recuperar contraseña olvidada.
