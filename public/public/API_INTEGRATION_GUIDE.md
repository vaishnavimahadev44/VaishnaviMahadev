# Frontend-Backend API Integration Guide

This guide explains how to integrate the frontend with the Laravel backend API.

## Table of Contents

1. [Setup](#setup)
2. [Basic Usage](#basic-usage)
3. [Authentication](#authentication)
4. [Making API Calls](#making-api-calls)
5. [Error Handling](#error-handling)
6. [Examples](#examples)
7. [Configuration](#configuration)

## Setup

### 1. Include the API Service

Add the API service script to your HTML files **before** any scripts that use it:

```html
<!-- Include API service first -->
<script src="api.js"></script>

<!-- Then include auth.js (which uses API service) -->
<script src="auth.js"></script>

<!-- Your other scripts -->
<script src="your-script.js"></script>
```

### 2. Configure API Base URL

By default, the API service points to `http://localhost:8000/api`. To change this:

```javascript
// Configure API base URL (do this before making any API calls)
window.API.configure({
    baseURL: 'https://your-production-domain.com/api'
});
```

### 3. Start Your Laravel Backend

Make sure your Laravel backend is running:

```bash
cd backend
php artisan serve
```

The backend should be accessible at `http://localhost:8000`.

## Basic Usage

### Test API Connection

```javascript
// Test if the API is accessible
window.API.test()
    .then(response => {
        console.log('API is working!', response);
    })
    .catch(error => {
        console.error('API connection failed:', error);
    });
```

## Authentication

### Register a New User

```javascript
window.API.auth.register('John Doe', 'john@example.com', 'password123', false)
    .then(result => {
        console.log('Registration successful:', result);
        console.log('User:', result.user);
        console.log('Token:', result.token);
    })
    .catch(error => {
        console.error('Registration failed:', error.message);
    });
```

### Login

```javascript
// Using the API service directly
window.API.auth.login('john@example.com', 'password123', false)
    .then(result => {
        console.log('Login successful:', result);
        // User is now authenticated
        window.location.href = 'dashboard.html';
    })
    .catch(error => {
        console.error('Login failed:', error.message);
        alert('Invalid email or password');
    });

// Or using the Auth wrapper (for backward compatibility)
window.Auth.login('john@example.com', 'password123', false)
    .then(result => {
        console.log('Login successful:', result);
    })
    .catch(error => {
        console.error('Login failed:', error.message);
    });
```

### Check Authentication Status

```javascript
// Check if user is authenticated
if (window.API.auth.isAuthenticated()) {
    console.log('User is logged in');
    const user = window.API.auth.getStoredUser();
    console.log('Current user:', user);
} else {
    console.log('User is not logged in');
}
```

### Get Current User

```javascript
// Get current authenticated user from backend
window.API.auth.getUser()
    .then(user => {
        console.log('Current user:', user);
    })
    .catch(error => {
        if (error.status === 401) {
            console.log('User is not authenticated');
            // Redirect to login
        }
    });
```

### Logout

```javascript
window.API.auth.logout()
    .then(() => {
        console.log('Logged out successfully');
        window.location.href = 'login.html';
    })
    .catch(error => {
        console.error('Logout error:', error);
    });

// Or using Auth wrapper
window.Auth.logout();
```

## Making API Calls

### Visa Applications

```javascript
// Get all visa applications
window.API.visaApplication.getAll()
    .then(applications => {
        console.log('Visa applications:', applications);
    })
    .catch(error => {
        console.error('Error fetching applications:', error);
    });

// Get a specific visa application
window.API.visaApplication.get(1)
    .then(application => {
        console.log('Application:', application);
    })
    .catch(error => {
        console.error('Error fetching application:', error);
    });

// Create a new visa application
window.API.visaApplication.create({
    name: 'John Doe',
    email: 'john@example.com',
    visa_type: 'tourist',
    // ... other fields
})
    .then(application => {
        console.log('Application created:', application);
    })
    .catch(error => {
        console.error('Error creating application:', error);
    });

// Update a visa application
window.API.visaApplication.update(1, {
    status: 'approved',
    // ... other fields to update
})
    .then(application => {
        console.log('Application updated:', application);
    })
    .catch(error => {
        console.error('Error updating application:', error);
    });

// Delete a visa application
window.API.visaApplication.delete(1)
    .then(() => {
        console.log('Application deleted');
    })
    .catch(error => {
        console.error('Error deleting application:', error);
    });
```

### Packages

```javascript
// Get all packages
window.API.package.getAll()
    .then(packages => {
        console.log('Packages:', packages);
    })
    .catch(error => {
        console.error('Error fetching packages:', error);
    });

// Create a new package
window.API.package.create({
    name: 'Premium Package',
    price: 299.99,
    description: 'Premium visa processing package',
    // ... other fields
})
    .then(package => {
        console.log('Package created:', package);
    })
    .catch(error => {
        console.error('Error creating package:', error);
    });
```

### Custom API Calls

For endpoints not covered by the API service:

```javascript
// GET request
window.API.request('/custom-endpoint')
    .then(data => {
        console.log('Response:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });

// POST request
window.API.request('/custom-endpoint', {
    method: 'POST',
    body: {
        field1: 'value1',
        field2: 'value2'
    }
})
    .then(data => {
        console.log('Response:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });

// PUT request
window.API.request('/custom-endpoint/1', {
    method: 'PUT',
    body: {
        field1: 'updated_value'
    }
})
    .then(data => {
        console.log('Response:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });

// DELETE request
window.API.request('/custom-endpoint/1', {
    method: 'DELETE'
})
    .then(data => {
        console.log('Response:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
```

## Error Handling

### Standard Error Handling

```javascript
window.API.visaApplication.getAll()
    .then(data => {
        // Handle success
        console.log('Success:', data);
    })
    .catch(error => {
        // Handle error
        if (error.status === 401) {
            // Unauthorized - redirect to login
            window.location.href = 'login.html';
        } else if (error.status === 403) {
            // Forbidden
            alert('You do not have permission to perform this action');
        } else if (error.status === 404) {
            // Not found
            alert('Resource not found');
        } else if (error.status === 422) {
            // Validation error
            console.error('Validation errors:', error.data.errors);
        } else if (error.status === 500) {
            // Server error
            alert('Server error. Please try again later.');
        } else {
            // Other errors
            alert(error.message || 'An error occurred');
        }
    });
```

### Network Error Handling

```javascript
window.API.test()
    .then(data => {
        console.log('Connected:', data);
    })
    .catch(error => {
        if (error.message.includes('Network error')) {
            alert('Cannot connect to server. Please check your connection and ensure the backend is running.');
        } else {
            console.error('Error:', error);
        }
    });
```

## Examples

### Complete Login Form Example

```html
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form id="loginForm">
        <input type="email" id="email" placeholder="Email" required>
        <input type="password" id="password" placeholder="Password" required>
        <label>
            <input type="checkbox" id="rememberMe"> Remember me
        </label>
        <button type="submit">Login</button>
        <div id="errorMessage" style="color: red; display: none;"></div>
    </form>

    <script src="api.js"></script>
    <script src="auth.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const rememberMe = document.getElementById('rememberMe').checked;
            const errorDiv = document.getElementById('errorMessage');
            
            // Clear previous errors
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            
            try {
                const result = await window.API.auth.login(email, password, rememberMe);
                console.log('Login successful:', result);
                
                // Redirect to dashboard
                window.location.href = 'dashboard.html';
            } catch (error) {
                // Show error message
                errorDiv.textContent = error.message || 'Login failed. Please try again.';
                errorDiv.style.display = 'block';
            }
        });
    </script>
</body>
</html>
```

### Loading Data on Page Load

```html
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <div id="userInfo"></div>
    <div id="applications"></div>
    <button id="logoutBtn">Logout</button>

    <script src="api.js"></script>
    <script src="auth.js"></script>
    <script>
        // Check authentication on page load
        if (!window.API.auth.isAuthenticated()) {
            window.location.href = 'login.html';
            throw new Error('Not authenticated');
        }

        // Load user info
        async function loadUserInfo() {
            try {
                const user = await window.API.auth.getUser();
                document.getElementById('userInfo').innerHTML = `
                    <h2>Welcome, ${user.name}!</h2>
                    <p>Email: ${user.email}</p>
                `;
            } catch (error) {
                console.error('Error loading user info:', error);
            }
        }

        // Load visa applications
        async function loadApplications() {
            try {
                const applications = await window.API.visaApplication.getAll();
                const appsDiv = document.getElementById('applications');
                
                if (applications.length === 0) {
                    appsDiv.innerHTML = '<p>No applications found.</p>';
                } else {
                    appsDiv.innerHTML = applications.map(app => `
                        <div>
                            <h3>${app.name || 'Application #' + app.id}</h3>
                            <p>Status: ${app.status || 'Pending'}</p>
                        </div>
                    `).join('');
                }
            } catch (error) {
                console.error('Error loading applications:', error);
                document.getElementById('applications').innerHTML = 
                    '<p style="color: red;">Error loading applications.</p>';
            }
        }

        // Logout handler
        document.getElementById('logoutBtn').addEventListener('click', function() {
            window.API.auth.logout();
        });

        // Load data when page loads
        loadUserInfo();
        loadApplications();
    </script>
</body>
</html>
```

### Creating a Visa Application

```javascript
async function createVisaApplication(formData) {
    try {
        // Ensure user is authenticated
        if (!window.API.auth.isAuthenticated()) {
            throw new Error('You must be logged in to create an application');
        }

        const application = await window.API.visaApplication.create({
            name: formData.name,
            email: formData.email,
            visa_type: formData.visaType,
            travel_date: formData.travelDate,
            // ... other fields
        });

        console.log('Application created:', application);
        alert('Application submitted successfully!');
        
        // Redirect or update UI
        return application;
    } catch (error) {
        if (error.status === 422) {
            // Validation errors
            const errors = error.data.errors;
            let errorMessage = 'Please fix the following errors:\n';
            for (const field in errors) {
                errorMessage += `- ${field}: ${errors[field].join(', ')}\n`;
            }
            alert(errorMessage);
        } else {
            alert(error.message || 'Failed to create application');
        }
        throw error;
    }
}

// Usage
document.getElementById('applicationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        visaType: document.getElementById('visaType').value,
        travelDate: document.getElementById('travelDate').value,
    };
    
    await createVisaApplication(formData);
});
```

## Configuration

### Backend CORS Configuration

Make sure your Laravel backend allows requests from your frontend domain. Update `backend/config/cors.php`:

```php
'allowed_origins' => [
    'http://localhost',
    'http://localhost:3000',
    'http://127.0.0.1',
    'https://your-production-domain.com'
],
```

### Sanctum Configuration

For SPA authentication, update `backend/config/sanctum.php`:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
    // Add your production domain here
    ',your-production-domain.com'
))),
```

### Environment Variables

In your `.env` file:

```env
APP_URL=http://localhost:8000
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1
```

## Troubleshooting

### Common Issues

1. **CORS Errors**
   - Make sure your backend CORS configuration allows your frontend domain
   - Check that the backend is running and accessible

2. **401 Unauthorized Errors**
   - Ensure the user is logged in
   - Check that the token is being sent in the Authorization header
   - Verify the token hasn't expired

3. **Network Errors**
   - Verify the backend is running (`php artisan serve`)
   - Check the API base URL configuration
   - Ensure there are no firewall issues

4. **404 Not Found**
   - Verify the API endpoint exists in `backend/routes/api.php`
   - Check that you're using the correct endpoint path

### Debugging

Enable console logging to debug API calls:

```javascript
// Before making API calls, you can log the configuration
console.log('API Base URL:', window.API ? 'Configured' : 'Not loaded');

// Log all API requests (add to api.js if needed)
const originalRequest = window.API.request;
window.API.request = function(...args) {
    console.log('API Request:', args);
    return originalRequest.apply(this, args);
};
```

## Next Steps

- Review the available API endpoints in `backend/routes/api.php`
- Implement error handling in your frontend
- Add loading states for better UX
- Implement token refresh if needed
- Add request interceptors for common headers or logging
