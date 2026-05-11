# IoT Delivery API

Laravel-based API for tracking delivery events from an IoT device, with realtime updates for connected clients. The backend receives status changes from an ESP32 device, stores each delivery record, and broadcasts updates so dashboards or web clients can react immediately.

## What it does

- Accepts delivery updates from a device through a simple JSON API.
- Stores delivery records with gate status, package status, and PIN data.
- Broadcasts `DeliveryUpdated` events over Laravel Reverb for realtime clients.
- Exposes read endpoints for web views or integrations that need delivery history.

## API Overview

All routes live under the `/api` prefix.

- `GET /api/delivery` returns a small service status response.
- `POST /api/delivery/info` receives delivery data from the ESP32 device.
- `GET /api/delivery/info` returns paginated delivery records.
- `GET /api/delivery/info/{id}` returns a single delivery record.
- `GET /api/delivery/user/{id}` looks up a user by ID.

Broadcast listeners can subscribe to:

- `delivery.info`
- `delivery.info.{id}`

## Data Flow

1. The ESP32 posts delivery status data to `POST /api/delivery/info`.
2. The API validates and stores the payload in the `deliveries` table.
3. A `DeliveryUpdated` event is broadcast immediately.
4. Realtime clients listening on the channel receive the updated delivery payload.

## Setup

1. Install dependencies:

	```bash
	composer install
	npm install
	```

2. Copy the environment file and generate an app key:

	```bash
	cp .env.example .env
	php artisan key:generate
	```

3. Run migrations:

	```bash
	php artisan migrate
	```

4. Start the app and Vite in separate terminals, or use the built-in dev script:

	```bash
	composer run dev
	```

## Environment

Make sure your `.env` file includes the usual database settings plus the Reverb variables used by `resources/js/echo.js`.

## Testing

Run the test suite with:

```bash
php artisan test
```

## Deployment
The app is deployed on Laravel Cloud on this link: https://iot-api-main-6oj5o8.laravel.cloud

## License

This project is open-sourced software licensed under the MIT license.
