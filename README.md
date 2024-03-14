# API PREX INTERVIEW

## Descripción

Esta API fue desarrollada en PHP utilizando Laravel 10 y está integrada con el servicio de GHIPY.

### Instrucciones para levantar la API

Para poder ejecutar esta API, sigue los siguientes pasos:

**Requisitos previos:**
Asegúrate de tener Docker y Docker Compose instalados en tu sistema. Si aún no los tienes, puedes consultar la guía de instalación en el siguiente enlace: [Docker Install](https://docs.docker.com/compose/install/)

**Pasos:**

1. Construye los contenedores ejecutando el siguiente comando en tu terminal:
   ```bash
   docker-compose up -d --build
   ```

2. Instala Passport dentro del contenedor de la API utilizando el siguiente comando:
   ```bash
   docker exec api php artisan passport:install --uuids
   ```

3. Realiza las migraciones de la base de datos con el siguiente comando:
   ```bash
   docker exec api php artisan migrate
   ```

Siguiendo estos pasos, podrás levantar la API y comenzar a utilizarla. ¡Disfruta de la experiencia!