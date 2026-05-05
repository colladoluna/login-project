# Proyecto Login

Sistema de login de usuarios desarrollado con PHP y MySQL como proyecto de DAW.

## Tecnologías usadas

- HTML
- CSS
- PHP
- MySQL
- XAMPP

## Funcionalidades

- Registro de usuarios
- Inicio y cierre de sesión
- Contraseñas encriptadas con password_hash()
- Consultas preparadas con PDO para evitar inyección SQL
- Página protegida solo accesible si has iniciado sesión

## Instalación

1. Instala XAMPP desde https://www.apachefriends.org
2. Copia la carpeta del proyecto dentro de: C:\xampp\htdocs\
3. Abre XAMPP y arranca **Apache** y **MySQL**
4. Abre phpMyAdmin en el navegador:http://localhost/phpmyadmin
5. Crea una base de datos llamada `login_db`
6. Importa el archivo `database.sql` que está en la carpeta `sql/`:
   - Selecciona la base de datos creada
   - Ve a la pestaña **Importar**
   - Selecciona el archivo y dale a **Continuar**
7. Abre la aplicación en el navegador.

## Usuarios de prueba

- Usuario: admin / Contraseña: admin123
- Usuario: prueba / Contraseña: prueba456
