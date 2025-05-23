# Gestión de Clientes y Reservas

## Dominio usado

La aplicación está desplegada en el dominio: 
**https://milanmc.me/gestionClientes**

Que tiene los siguientes archivos: 
clientes.php  conexion.php  crear_cliente.php  crear_reserva.php  editar_cliente.php  editar_reserva.php  eliminar_cliente.php  eliminar_reserva.php  index.php  reservas.php  todasLasReservas.php

---

## Explicación proyecto

## 1. Estructura del proyecto

El proyecto se encuentra en la ruta:
```
/var/www/milanmc.me/gestionClientes
```
Incluye los siguientes archivos principales:
- `index.php`: Landing page con acceso a Clientes y Reservas
- `clientes.php`: Listado y gestión de clientes
- `reservas.php`: Listado y gestión de reservas asociadas a cada cliente
- `todasLasReservas.php`: Listado de todas las reservas
- CRUD de clientes: `crear_cliente.php`, `editar_cliente.php`, `eliminar_cliente.php`
- CRUD de reservas: `crear_reserva.php`, `editar_reserva.php`, `eliminar_reserva.php`
- `conexion.php`: Conexión a la base de datos mediante PDO

---

## 2. Creación de la base de datos y usuario

### Script usado

```sql
CREATE DATABASE gestion_clientes;

USE gestion_clientes;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    fecha_nacimiento DATE,
    telefono VARCHAR(20),
    email VARCHAR(100)
);

CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    precio DECIMAL(10,2),
    observaciones TEXT,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id) ON DELETE CASCADE
);
```

### Creación de usuario y permisos

```sql
CREATE USER 'gestioncliente'@'localhost' IDENTIFIED BY '12341234';
GRANT ALL PRIVILEGES ON gestion_clientes.* TO 'gestioncliente'@'localhost';
FLUSH PRIVILEGES;
```

---

## 3. Configuración de la conexión en PHP

El archivo `conexion.php` utiliza PDO para una conexión segura y eficiente a MySQL:

```php
<?php
$host = 'localhost';
$db = 'gestion_clientes';
$user = 'gestioncliente';
$pass = '12341234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
```

> **Nota:** Se recomienda reemplazar las credenciales por variables de entorno en producción y eliminar el `echo` en producción para mayor seguridad.

---

## 4. Permisos de ficheros recomendados

```bash
sudo chown -R www-data:www-data /var/www/milanmc.me/gestionClientes
sudo find /var/www/milanmc.me/gestionClientes -type d -exec chmod 755 {} \;
sudo find /var/www/milanmc.me/gestionClientes -type f -exec chmod 644 {} \;
```

---

## 5. Estructura y funcionamiento de la aplicación

- **Landing page (index.php):** 
  Página principal con botones para acceder a la gestión de Clientes o Reservas. 
  !(imagen1.png).

- **Gestión de Clientes (clientes.php):** 
  Listado de clientes con opciones para crear, editar, eliminar y buscar clientes. 
  _[aquí puede ir una captura de pantalla]_

- **Añadir nuevo cliente:** 
  Botón en la sección de clientes para agregar uno nuevo. 
  _[aquí puede ir una captura de pantalla]_

- **Gestión de Reservas (reservas.php/todasLasReservas.php):** 
  Listado de reservas, posibilidad de crear, editar o eliminar reservas asociadas a clientes. 
  _[aquí puede ir una captura de pantalla]_

- **Búsqueda:** 
  Permite buscar clientes por nombre o apellidos. 
  _[aquí puede ir una captura de pantalla]_

- **Ver reservas de un cliente:** 
  Desde la lista de clientes se puede acceder a las reservas de ese cliente. 
  _[aquí puede ir una captura de pantalla]_

- **CRUD completo:** 
  La aplicación permite crear, leer, actualizar y eliminar tanto clientes como reservas de manera sencilla y visual, usando formularios PHP conectados a la base de datos mediante PDO.

---

## 7. Notas adicionales

- **Se utiliza PDO (PHP Data Objects) en todos los scripts para la gestión de la base de datos por seguridad y facilidad de uso.**
