# Prueba Gif Prex

Prueba para el proceso de seleccion.

## Requisitos Previos

Asegúrate de tener instalados los siguientes requisitos antes de comenzar:

- **Docker**
- **Docker Compose**

## Instalación

Para levantar el proyecto, sigue los siguientes pasos:

### 1. Cambiar los .env

En la carpeta  `prueba-prex` renombrar `.env.example` y `.env.testing.example` por `.env` y `.env.testing` y agregar la api key de giphy.
### 2. Levantar los Contenedores con Docker Compose

Ve a la carpeta `docker-compose` donde se encuentra el archivo `docker-compose.yml` y ejecuta el siguiente comando para levantar los contenedores en segundo plano.
```bash
docker-compose up -d
```
### 3. Acceder al Contenedor y Configurar la Aplicación

Una vez que los contenedores estén en funcionamiento, necesitas acceder al contenedor de la aplicación Laravel para ejecutar algunos comandos de configuración.
Para acceder al mismo lo puedes hacer con:
```bash
docker exec -it prueba-prex-app bash
```

#### Paso 1: Generar la **App Key** de Laravel

Para generar la APP_KEY debes correr dentro del contenedor el siguiente comando:

```bash
php artisan key:generate
```

#### Paso 2: Correr migraciones 

Para generar las tablas debes correr dentro del contenedor el siguiente comando:

```bash
php artisan migrate
```

#### Paso 3: Correr sedders

Para poblar la tabla users debes correr dentro del contenedor el siguiente comando:

```bash
php artisan db:seed
```

#### Paso 3: Generar las access key de passport

Correr dentro del contenedor el siguiente comando:

```bash
php artisan passport:install
```

### 4. Preparar base de datos para tests
Acceder al contenedor de la base de datos para ejecutar algunos comandos de configuración.
Para acceder al mismo lo puedes hacer con:
```bash
docker exec -it prueba-prex-mysql bash
```
#### Paso 1: Acceder como user root

Para acceder como root correr dentro del contenedor el siguiente comando:

```bash
mysql -u root -p
```
la password es **root**
#### Paso 2: Crear base de datos de test
Correr la siguiente consulta de creacion:
```bash
CREATE DATABASE prueba_prex_test;
```
Salir del contenedor de mysql con **exit** dos veces 
#### Paso 3: Generar APP KEY y correr migraciones para tests
Acceder al contenedor
```bash
docker exec -it prueba-prex-app bash
```
Para generar la APP_KEY de los test debes correr dentro del contenedor el siguiente comando:

```bash
php artisan key:generate --env=testing
```
Para generar las tablas de test debes correr dentro del contenedor el siguiente comando:

```bash
php artisan migrate --env=testing
```
### 5. Agregar la URL al Archivo Hosts

Es posible que necesites agregar la URL del contenedor de tu aplicación a tu archivo de hosts para poder acceder a ella desde tu navegador. Sigue los siguientes pasos según tu sistema operativo.

#### En **Windows**:

1. Abre el archivo `hosts` como administrador. Este archivo se encuentra en `C:\Windows\System32\drivers\etc\hosts`.
2. Agrega la siguiente línea al final del archivo: `127.0.0.1 prueba-prex.local`

#### En **Linux**:

1. Abre el archivo `hosts` con privilegios de superusuario. Puedes hacerlo con el siguiente comando en la terminal:
```bash
sudo nano /etc/hosts
```
Agrega la siguiente línea al final del archivo:`127.0.0.1 prueba-prex.local`
