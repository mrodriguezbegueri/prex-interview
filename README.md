# API PREX INTERVIEW

## Descripción

Esta API fue desarrollada en PHP utilizando Laravel 10 con PHP 8.3 y está integrada con el servicio de GHIPY.

### Instrucciones para levantar la API

Para poder ejecutar esta API, sigue los siguientes pasos:

**Requisitos previos:**
Asegúrate de tener Docker y Docker Compose instalados en tu sistema. Si aún no los tienes, puedes consultar la guía de instalación en el siguiente enlace: [Docker Install](https://docs.docker.com/compose/install/)

**Pasos:**

1. Crea el archivo `.env` en la raíz del proyecto y configura las variables de entorno necesarias. (El archivo .env.example tiene lo necesario para interactuar con la base de datos creada por el docker-compose.yml)

2. Configurar las variables de ambientes de GHIPY 
    ```
    GIPHY_DEV_API_KEY=xxxxx
    GIPHY_API_URL=api.giphy.com/v1
    ```
    Donde "GIPHY_DEV_API_KEY" debe ser una key valida del servicio GHIPY. Esta se puede encontrar siguiendo la siguiente guía: [GHIPY](https://developers.giphy.com/docs/api/#quick-start-guide)

3. Construye los contenedores ejecutando el siguiente comando en tu terminal:
    ```bash
    docker-compose up -d
    ```
4. Realiza las migraciones de la base de datos con el siguiente comando:
    ```bash
    docker exec api php artisan migrate
    ```

5. Instala Passport dentro del contenedor de la API utilizando el siguiente comando:
    ```bash
    docker exec api php artisan passport:install --uuids
    ```

Siguiendo estos pasos, podrás levantar la API y comenzar a utilizarla.


## Colección de Postman

También se proporciona una colección de Postman que contiene ejemplos de solicitudes para interactuar con la API. Puedes encontrar la colección en el proyecto, dentro de la carpeta `docs/postman`.

Para importar la colección en tu cliente de Postman, sigue estos pasos:

1. Abre Postman.
2. Haz clic en el botón "Archivo" en la esquina superior izquierda y selecciona "Importar".
3. Selecciona el workspace en caso de ser necesario y arrastra el archivo de la colección en la ubicación mencionada anteriormente.
4. Haz clic en "Importar" para cargar la colección en tu cliente de Postman.

Una vez importada la colección, podrás ver y ejecutar las solicitudes predefinidas para probar la API de manera fácil y rápida.

## Documentación

En la carpeta "docs" dentro de la raiz del proyecto, se puede encontrar documentación más específica respecto al diseño de la API.