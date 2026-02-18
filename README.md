# API REST Resultados Clínicos (Laravel 10+)

Sistema backend para consulta de resultados clínicos, diseñado para integrarse con un portal de pacientes y un bridge interno.

## Requerimientos

- PHP 8.1 o superior
- Composer
- MySQL 8.0+
- Extensiones PHP: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalación

1. **Clonar el repositorio/Copiar archivos**
   ```bash
   git clone <url-del-repo>
   cd Api
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar Entorno**
   ```bash
   cp .env.example .env
   ```
   Edita el archivo `.env` y configura tu base de datos y la `BRIDGE_API_KEY`.

4. **Generar Claves**
   ```bash
   php artisan key:generate
   php artisan jwt:secret
   ```

5. **Migrar Base de Datos**
   ```bash
   php artisan migrate
   ```

## Seguridad

- **JWT Authentication**: Usado para el acceso de pacientes.
- **API Key**: Usada para el endpoint interno `internal/resultados`. Debe enviarse el header `X-API-KEY`.
- **Rate Limiting**: Configurado por defecto en `RouteServiceProvider`.
- **Logs**: Habilitados en `storage/logs`.

## Endpoints

### 1. Autenticación (Pacientes)

- **POST** `/api/auth/login`
  - Body: `{"email": "paciente@email.com", "password": "password"}`
  - Response: `{ "access_token": "...", "token_type": "bearer", ... }`

- **POST** `/api/auth/me`
  - Header: `Authorization: Bearer <token>`
  - Response: Datos del paciente.

### 2. Resultados (Pacientes)

- **GET** `/api/resultados`
  - Header: `Authorization: Bearer <token>`
  - Response: Lista de resultados firmados (`fecha_validacion` no nula).

### 3. Bridge Interno (Carga de Datos)

- **POST** `/api/internal/resultados`
  - Header: `X-API-KEY: <Valor de BRIDGE_API_KEY en .env>`
  - Body: Array JSON de resultados (ver `example_payload.json`).
  - Response: Status 200 OK.

## Notas de Producción

- Asegúrate de configurar `APP_ENV=production` y `APP_DEBUG=false` en el archivo `.env`.
- La clave `BRIDGE_API_KEY` debe ser larga y segura.
- Configurar SSL (HTTPS) es obligatorio para proteger las credenciales y los datos médicos.
