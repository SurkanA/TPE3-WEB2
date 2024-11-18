# TPE3-WEB2
# API de Equipos

Este proyecto proporciona una API para gestionar equipos de fútbol. A continuación se detallan los puntos finales (endpoints) disponibles para interactuar con la API.

## Endpoints

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

4. Eliminar un equipo
Método: DELETE
URL: api/equipo/{nombre_equipo}
Descripción: Elimina un equipo especificado por su nombre.
5. Editar un equipo
Método: PUT
URL: api/equipo/{nombre_equipo}
Descripción: Actualiza la información de un equipo.
Formato de solicitud (JSON):
json
Copiar código
{
  "id_equipo": 40,
  "nombre_equipo": "Platnce",
  "ciudad": "Buenos Aires",
  "year_fundado": "1905",
  "biografia": "Rival clásico de nadie",
  "imagen_url": null
}