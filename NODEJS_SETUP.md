# Node.js Connection to Laravel Backend

This guide explains how to connect your Node.js application to the Laravel backend API.

## Backend Setup (Laravel)

The Laravel backend has been configured with:
- ✅ CORS enabled for cross-origin requests
- ✅ API routes at `/api/*`
- ✅ Example API endpoints

### Starting the Laravel Backend

1. Navigate to the backend folder:
   ```bash
   cd backend
   ```

2. Start the Laravel development server:
   ```bash
   php artisan serve
   ```
   
   The API will be available at: `http://localhost:8000`

3. Test the API endpoint:
   ```bash
   curl http://localhost:8000/api/test
   ```

## Node.js Client Setup

### 1. Install Dependencies

In the root directory, install the required packages:

```bash
npm install
```

This will install `axios` for making HTTP requests.

### 2. Run the Example

```bash
node nodejs-example.js
```

Or use npm:

```bash
npm start
```

### 3. Using in Your Own Node.js Application

You can import and use the API client in your own files:

```javascript
const { apiClient, testConnection, getUsers } = require('./nodejs-example');

// Test connection
await testConnection();

// Get users
await getUsers();
```

Or create your own axios instance:

```javascript
const axios = require('axios');

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

// Make requests
const response = await apiClient.get('/test');
console.log(response.data);
```

## API Endpoints

### Available Endpoints

- `GET /api/test` - Test endpoint to verify API is working
- `GET /api/users` - Get users (example endpoint)

### Adding Your Own Endpoints

1. Add routes in `backend/routes/api.php`:
   ```php
   Route::get('/your-endpoint', function () {
       return response()->json(['message' => 'Hello from Laravel!']);
   });
   ```

2. Access from Node.js:
   ```javascript
   const response = await apiClient.get('/your-endpoint');
   ```

## CORS Configuration

CORS is configured in `backend/config/cors.php`. By default, it allows:
- All origins (`*`)
- All methods (`*`)
- All headers (`*`)

To restrict access, modify the CORS configuration:

```php
'allowed_origins' => ['http://localhost:3000'], // Specific origins
'supports_credentials' => true, // If you need cookies/auth
```

## Authentication

If you need to add authentication:

1. **Laravel Sanctum** (recommended for SPA/API):
   ```bash
   cd backend
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

2. **Send token from Node.js**:
   ```javascript
   apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`;
   ```

## Example Usage

### GET Request
```javascript
const response = await apiClient.get('/users');
console.log(response.data);
```

### POST Request
```javascript
const response = await apiClient.post('/users', {
    name: 'John Doe',
    email: 'john@example.com'
});
```

### PUT Request
```javascript
const response = await apiClient.put('/users/1', {
    name: 'Jane Doe'
});
```

### DELETE Request
```javascript
const response = await apiClient.delete('/users/1');
```

## Troubleshooting

### Connection Refused
- Make sure Laravel server is running: `php artisan serve`
- Check the port (default is 8000)
- Verify the API_BASE_URL in your Node.js code

### CORS Errors
- Check `backend/config/cors.php` configuration
- Ensure your frontend origin is allowed
- Check browser console for specific CORS errors

### 404 Not Found
- Verify the route exists in `backend/routes/api.php`
- Check that API routes are enabled in `backend/bootstrap/app.php`
- Ensure you're using `/api/` prefix in your requests

## Next Steps

1. Add your own API endpoints in `backend/routes/api.php`
2. Create controllers for better organization
3. Add authentication if needed
4. Set up database models and migrations
5. Implement proper error handling

