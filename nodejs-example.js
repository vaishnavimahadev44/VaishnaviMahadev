

const axios = require('axios');


const API_BASE_URL = 'http://localhost:8000/api'; 


const apiClient = axios.create({
    baseURL: API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    timeout: 10000, 
});


async function testConnection() {
    try {
        console.log('Testing API connection...');
        const response = await apiClient.get('/test');
        console.log('✅ Connection successful!');
        console.log('Response:', response.data);
        return response.data;
    } catch (error) {
        console.error('❌ Connection failed:', error.message);
        if (error.response) {
            console.error('Response data:', error.response.data);
            console.error('Status:', error.response.status);
        }
        throw error;
    }
}


async function getUsers() {
    try {
        console.log('\nFetching users...');
        const response = await apiClient.get('/users');
        console.log('✅ Users fetched successfully!');
        console.log('Response:', response.data);
        return response.data;
    } catch (error) {
        console.error('❌ Failed to fetch users:', error.message);
        throw error;
    }
}


async function createUser(userData) {
    try {
        console.log('\nCreating user...');
        const response = await apiClient.post('/users', userData);
        console.log('✅ User created successfully!');
        console.log('Response:', response.data);
        return response.data;
    } catch (error) {
        console.error('❌ Failed to create user:', error.message);
        if (error.response) {
            console.error('Error details:', error.response.data);
        }
        throw error;
    }
}


 
async function updateUser(userId, userData) {
    try {
        console.log(`\nUpdating user ${userId}...`);
        const response = await apiClient.put(`/users/${userId}`, userData);
        console.log('✅ User updated successfully!');
        console.log('Response:', response.data);
        return response.data;
    } catch (error) {
        console.error('❌ Failed to update user:', error.message);
        throw error;
    }
}


async function deleteUser(userId) {
    try {
        console.log(`\nDeleting user ${userId}...`);
        const response = await apiClient.delete(`/users/${userId}`);
        console.log('✅ User deleted successfully!');
        console.log('Response:', response.data);
        return response.data;
    } catch (error) {
        console.error('❌ Failed to delete user:', error.message);
        throw error;
    }
}


function setAuthToken(token) {
    apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}


 

function removeAuthToken() {
    delete apiClient.defaults.headers.common['Authorization'];
}

async function main() {
    console.log('🚀 Node.js Laravel API Client Example\n');
    console.log(`Backend URL: ${API_BASE_URL}\n`);
    
    
    await testConnection();
    
    
    await getUsers();
    
    
    
    console.log('\n✨ Example completed!');
}


if (require.main === module) {
    main().catch(console.error);
}


module.exports = {
    apiClient,
    testConnection,
    getUsers,
    createUser,
    updateUser,
    deleteUser,
    setAuthToken,
    removeAuthToken,
};

