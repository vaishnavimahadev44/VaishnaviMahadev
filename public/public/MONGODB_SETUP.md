# MongoDB Frontend Connection Setup Guide

This guide explains how to connect to MongoDB from the frontend using the MongoDB Atlas Data API.

## Prerequisites

1. A MongoDB Atlas account (free tier available)
2. A MongoDB Atlas cluster
3. MongoDB Atlas Data API enabled

## Setup Steps

### Step 1: Create MongoDB Atlas Account and Cluster

1. Go to [MongoDB Atlas](https://www.mongodb.com/cloud/atlas)
2. Sign up for a free account
3. Create a new cluster (free tier M0 is sufficient)
4. Wait for the cluster to be created

### Step 2: Enable Data API

1. In MongoDB Atlas, go to your project
2. Click on "Data API" in the left sidebar
3. Click "Create Data API Application"
4. Give it a name (e.g., "Frontend App")
5. Copy the following information:
   - **API Key**: Generated API key
   - **App ID**: Found in the Data API URL
   - **Base URL**: `https://data.mongodb-api.com/app/YOUR_APP_ID/endpoint/data/v1`

### Step 3: Configure Database Access

1. Go to "Database Access" in MongoDB Atlas
2. Create a database user with read/write permissions
3. Note the username and password

### Step 4: Configure Network Access

1. Go to "Network Access" in MongoDB Atlas
2. Add your IP address or use `0.0.0.0/0` for development (not recommended for production)

### Step 5: Use in Your Frontend Code

#### Basic Usage

```html
<!-- Include the MongoDB connection script -->
<script src="mongodb.js"></script>

<script>
    // Initialize MongoDB connection
    window.MongoDB.init({
        apiKey: 'YOUR_API_KEY',
        dataSource: 'Cluster0', // Your cluster name
        database: 'mydb',
        collection: 'users',
        baseUrl: 'https://data.mongodb-api.com/app/YOUR_APP_ID/endpoint/data/v1'
    });

    // Test connection
    window.MongoDB.testConnection()
        .then(result => console.log('Connection:', result))
        .catch(error => console.error('Error:', error));

    // Insert a document
    window.MongoDB.insertOne({ name: 'John Doe', email: 'john@example.com' })
        .then(result => console.log('Inserted:', result))
        .catch(error => console.error('Error:', error));

    // Find documents
    window.MongoDB.find({ name: 'John Doe' })
        .then(documents => console.log('Found:', documents))
        .catch(error => console.error('Error:', error));

    // Update a document
    window.MongoDB.updateOne(
        { email: 'john@example.com' },
        { $set: { name: 'Jane Doe' } }
    )
        .then(result => console.log('Updated:', result))
        .catch(error => console.error('Error:', error));

    // Delete a document
    window.MongoDB.deleteOne({ email: 'john@example.com' })
        .then(result => console.log('Deleted:', result))
        .catch(error => console.error('Error:', error));
</script>
```

## Available Methods

### `MongoDB.init(config)`
Initialize MongoDB connection with configuration.

### `MongoDB.find(filter, options)`
Find multiple documents matching the filter.

### `MongoDB.findOne(filter, options)`
Find a single document matching the filter.

### `MongoDB.insertOne(document, options)`
Insert a single document.

### `MongoDB.insertMany(documents, options)`
Insert multiple documents.

### `MongoDB.updateOne(filter, update, options)`
Update a single document.

### `MongoDB.updateMany(filter, update, options)`
Update multiple documents.

### `MongoDB.deleteOne(filter, options)`
Delete a single document.

### `MongoDB.deleteMany(filter, options)`
Delete multiple documents.

### `MongoDB.count(filter, options)`
Count documents matching the filter.

### `MongoDB.testConnection()`
Test the MongoDB connection.

## Security Notes

⚠️ **Important Security Considerations:**

1. **API Keys**: Never commit API keys to version control. Use environment variables or secure storage.
2. **CORS**: Configure CORS properly in MongoDB Atlas Data API settings.
3. **Rate Limiting**: Be aware of rate limits on the free tier.
4. **Data Validation**: Always validate data on the client side before sending to MongoDB.
5. **Production**: For production, consider using a backend API instead of direct frontend connections.

## Example: Using with Authentication

```javascript
// Store config in localStorage (not recommended for production)
const config = {
    apiKey: localStorage.getItem('mongodb_api_key'),
    dataSource: 'Cluster0',
    database: 'mydb',
    collection: 'users',
    baseUrl: 'https://data.mongodb-api.com/app/YOUR_APP_ID/endpoint/data/v1'
};

window.MongoDB.init(config);

// Use in your authentication flow
async function loginUser(email, password) {
    const user = await window.MongoDB.findOne(
        { email: email },
        { collection: 'users' }
    );
    
    if (user && user.password === password) {
        // Handle successful login
        return user;
    }
    throw new Error('Invalid credentials');
}
```

## Troubleshooting

### Connection Failed
- Verify your API key is correct
- Check that Data API is enabled in MongoDB Atlas
- Ensure your IP address is whitelisted
- Verify the base URL includes the correct App ID

### CORS Errors
- Configure CORS in MongoDB Atlas Data API settings
- Add your domain to allowed origins

### Authentication Errors
- Verify your database user has proper permissions
- Check that the database and collection names are correct

## Alternative: MongoDB Realm SDK

For more advanced features, you can also use MongoDB Realm SDK:

```html
<script src="https://realm.mongodb.com/generated/js/realm-web-1.12.0.js"></script>
<script>
    const app = new Realm.App({ id: "YOUR_REALM_APP_ID" });
    
    async function login() {
        const credentials = Realm.Credentials.anonymous();
        const user = await app.logIn(credentials);
        return user;
    }
</script>
```

## Support

For more information, visit:
- [MongoDB Atlas Documentation](https://docs.atlas.mongodb.com/)
- [MongoDB Data API Documentation](https://docs.atlas.mongodb.com/api/data-api/)

