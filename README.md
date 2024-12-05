# TPE3-WEB2
## API de Equipos

Este proyecto proporciona una API para gestionar equipos de fútbol. A continuación se detallan los puntos finales (endpoints) disponibles para interactuar con la API.

# Endpoints

## Equipos

### 1. Obtener todos los equipos
- **Método:** GET
- **URL:** `api/equipo`
- **Descripción:** Obtiene todos los equipos registrados en la base de datos.

### 2. Obtener un solo equipo
- **Método:** GET
- **URL:** `api/equipo/{nombre_equipo}`
- **Descripción:** Obtiene un solo equipo especificado por su nombre. Los ID funcionan a través del nombre del equipo.

### 3. Crear un equipo
- **Método:** POST
- **URL:** `api/equipo`
- **Descripción:** Crea un nuevo equipo.
- **Formato de solicitud (JSON):**
  ```json
  {
    "id_equipo": 40,
    "nombre_equipo": "Platnce",
    "ciudad": "Buenos Aires",
    "year_fundado": "1905",
    "biografia": "Rival clásico de nadie",
    "imagen_url": null
  }

### 4. Eliminar un equipo
- **Método:** DELETE
- **URL:** `api/equipo/{nombre_equipo}`
- **Descripción:** Elimina un equipo especificado por su nombre.

### 5. Editar un equipo
- **Método:** PUT
- **URL:** `api/equipo/{nombre_equipo}`
- **Descripción:** Actualiza la información de un equipo.
- **Formato de solicitud (JSON):**
  ```json
  {
    "id_equipo": 40,
    "nombre_equipo": "Platnce",
    "ciudad": "Buenos Aires",
    "year_fundado": "1905",
    "biografia": "Rival clásico de nadie",
    "imagen_url": null
  }
  
## Jugadores

### 1. Obtener todos los jugadores
- **Método:** GET
- **URL:** `api/jugador`
- **Descripción:** Obtiene todos los jugadores registrados en la base de datos.

### 2. Obtener jugadores paginados
- **Método:** GET
- **URL:** `api/jugadores/paginar/{cantidad}`
- **Descripción:** Obtiene jugadores paginados segun la cantidad asignada empezando por el ultimo hasta el primero.

### 3. Obtener jugadores filtrados
- **Método:** GET
- **URL:** `api/jugadores/filtrar/{filtro}/{valor}`
- **Descripción:** Obtiene jugadores que coinciden con un filtro específico (nombre, equipo, id, edad, posicion, imagen) y un valor específico.

### 4. Obtener jugadores ordenados
- **Método:** GET
- **URL:** `api/jugadores/ordenar/{categoria}/{orden}`
- **Descripción:** Obtiene jugadores ordenados por una categoría específica (nombre, equipo, id, edad, posicion, imagen) y un orden específico (ascendente o descendente).

### 5. Obtener un solo jugador
- **Método:** GET
- **URL:** `api/jugador/{nombre_equipo}/{id_jugador}`
- **Descripción:** Obtiene un solo jugador especificado por su equipo y ID.

### 6. Crear un jugador
- **Método:** POST
- **URL:** `api/jugador`
- **Descripción:** Crea un nuevo jugador, se necesita un Basic Auth.
- **Formato de solicitud (JSON):**
  ```json
  {
    "nombre_jugador": "Messi",
    "nombre_equipo": "Barcelona",
    "id_jugador": 10,
    "edad": 35,
    "posicion": "Delantero",
    "biografia": "Opcional, no poner nada le dara una descripcion generica",
    "imagen_url": "Opcional, no poner nada le dara una imagen generica"
  }

### 7. Editar un jugador
- **Método:** PUT
- **URL:** `api/jugador/{nombre_equipo}/{id_jugador}`
- **Descripción:** Actualiza la información de un jugador, se necesita un Basic Auth.
- **Formato de solicitud (JSON):**
  ```json
  {
    "nombre_jugador": "Messi",
    "nombre_equipo": "Barcelona",
    "id_jugador": 10,
    "edad": 35,
    "posicion": "Delantero",
    "biografia": "Opcional, no poner nada le dara una descripcion generica",
    "imagen_url": "Opcional, no poner nada le dara una imagen generica"
  }

### 8. Eliminar un jugador
- **Método:** DELETE
- **URL:** `api/jugador/{nombre_equipo}/{id_jugador}`
- **Descripción:** Elimina un jugador existente.
