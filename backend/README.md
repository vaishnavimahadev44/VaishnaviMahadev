# AMS Backend - Node.js Express API

A Node.js Express backend server for the AMS (Application Management System) application.

## Features

- Express.js RESTful API
- MySQL database integration
- CORS enabled
- Request logging with Morgan
- Environment variable configuration
- Error handling middleware
- User CRUD operations

## Prerequisites

- Node.js (v14 or higher)
- MySQL database
- npm or yarn

## Installation

1. Install dependencies:
```bash
npm install
```

2. Create a `.env` file in the backend directory (copy from `.env.example`):
```bash
cp .env.example .env
```

3. Update the `.env` file with your database credentials:
```
DB_HOST=localhost
DB_USER=your_username
DB_PASSWORD=your_password
DB_NAME=ams_db
PORT=3000
```

4. Make sure your MySQL database exists. You can create it with:
```sql
CREATE DATABASE ams_db;
```

## Running the Server

### Development Mode (with auto-reload):
```bash
npm run dev
```

### Production Mode:
```bash
npm start
```

The server will start on `http://localhost:3000` (or the port specified in your `.env` file).

## API Endpoints

### Health Check
- `GET /health` - Check if server is running

### Test
- `GET /api/test` - Test API connection

### Users
- `GET /api/users` - Get all users
- `POST /api/users` - Create a new user
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "optional"
  }
  ```
- `PUT /api/users/:id` - Update a user
- `DELETE /api/users/:id` - Delete a user

## Project Structure

```
backend/
├── config/
│   └── database.js      # Database configuration
├── controllers/
│   └── userController.js # User business logic
├── routes/
│   └── api.js           # API routes
├── server.js            # Main server file
├── .env.example         # Environment variables template
├── .gitignore
├── package.json
└── README.md
```

## Database Schema

The application expects a `users` table with the following structure:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Error Handling

The API returns standardized error responses:
- `400` - Bad Request
- `404` - Not Found
- `409` - Conflict (e.g., duplicate email)
- `500` - Internal Server Error

## Development

To add new features:
1. Create controllers in `controllers/`
2. Add routes in `routes/api.js`
3. Update database schema if needed

## License

MIT

