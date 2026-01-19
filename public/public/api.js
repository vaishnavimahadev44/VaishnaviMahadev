/**
 * API Service for Laravel Backend Integration
 * Handles all HTTP requests to the Laravel API backend
 */

(function() {
    'use strict';

    // Configuration
    const API_CONFIG = {
        // Change this to your Laravel backend URL
        // For development: http://localhost:8000
        // For production: https://your-domain.com
        baseURL: 'http://localhost:8000/api',
        
        // Storage keys
        TOKEN_KEY: 'auth_token',
        USER_KEY: 'auth_user',
        
        // Default headers
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    };

    /**
     * Get authentication token from storage
     */
    function getToken() {
        try {
            return localStorage.getItem(API_CONFIG.TOKEN_KEY) || sessionStorage.getItem(API_CONFIG.TOKEN_KEY);
        } catch (e) {
            return null;
        }
    }

    /**
     * Set authentication token in storage
     */
    function setToken(token, useLocalStorage = false) {
        try {
            if (useLocalStorage) {
                localStorage.setItem(API_CONFIG.TOKEN_KEY, token);
            } else {
                sessionStorage.setItem(API_CONFIG.TOKEN_KEY, token);
            }
        } catch (e) {
            console.error('Failed to store token:', e);
        }
    }

    /**
     * Remove authentication token from storage
     */
    function removeToken() {
        try {
            localStorage.removeItem(API_CONFIG.TOKEN_KEY);
            sessionStorage.removeItem(API_CONFIG.TOKEN_KEY);
            localStorage.removeItem(API_CONFIG.USER_KEY);
            sessionStorage.removeItem(API_CONFIG.USER_KEY);
        } catch (e) {
            console.error('Failed to remove token:', e);
        }
    }

    /**
     * Get current user from storage
     */
    function getCurrentUser() {
        try {
            const userStr = localStorage.getItem(API_CONFIG.USER_KEY) || sessionStorage.getItem(API_CONFIG.USER_KEY);
            return userStr ? JSON.parse(userStr) : null;
        } catch (e) {
            return null;
        }
    }

    /**
     * Set current user in storage
     */
    function setCurrentUser(user, useLocalStorage = false) {
        try {
            const userStr = JSON.stringify(user);
            if (useLocalStorage) {
                localStorage.setItem(API_CONFIG.USER_KEY, userStr);
            } else {
                sessionStorage.setItem(API_CONFIG.USER_KEY, userStr);
            }
        } catch (e) {
            console.error('Failed to store user:', e);
        }
    }

    /**
     * Make HTTP request to API
     */
    async function request(endpoint, options = {}) {
        const url = `${API_CONFIG.baseURL}${endpoint}`;
        const token = getToken();

        // Prepare headers
        const headers = {
            ...API_CONFIG.headers,
            ...options.headers
        };

        // Add authorization header if token exists
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        // Prepare request options
        const requestOptions = {
            method: options.method || 'GET',
            headers: headers,
            ...options
        };

        // Add body for POST, PUT, PATCH requests
        if (['POST', 'PUT', 'PATCH'].includes(requestOptions.method) && options.body) {
            if (typeof options.body === 'object') {
                requestOptions.body = JSON.stringify(options.body);
            }
        }

        try {
            const response = await fetch(url, requestOptions);
            
            // Parse response
            let data;
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                data = await response.json();
            } else {
                data = await response.text();
            }

            // Handle errors
            if (!response.ok) {
                const error = new Error(data.message || `HTTP error! status: ${response.status}`);
                error.status = response.status;
                error.data = data;
                throw error;
            }

            return data;
        } catch (error) {
            // Handle network errors
            if (error.name === 'TypeError' && error.message.includes('fetch')) {
                throw new Error('Network error: Unable to connect to the server. Please check your connection and ensure the backend is running.');
            }
            throw error;
        }
    }

    /**
     * API Service Object
     */
    window.API = {
        /**
         * Configure API base URL
         */
        configure: function(config) {
            if (config.baseURL) {
                API_CONFIG.baseURL = config.baseURL;
            }
        },

        /**
         * Authentication Methods
         */
        auth: {
            /**
             * Register a new user
             * @param {string} name - User's name
             * @param {string} email - User's email
             * @param {string} password - User's password
             * @param {boolean} rememberMe - Whether to use localStorage (true) or sessionStorage (false)
             * @returns {Promise}
             */
            register: async function(name, email, password, rememberMe = false) {
                try {
                    const response = await request('/register', {
                        method: 'POST',
                        body: { name, email, password }
                    });

                    if (response.token && response.user) {
                        setToken(response.token, rememberMe);
                        setCurrentUser(response.user, rememberMe);
                        
                        // Dispatch login event
                        window.dispatchEvent(new CustomEvent('auth:login', {
                            detail: { user: response.user }
                        }));

                        return {
                            success: true,
                            token: response.token,
                            user: response.user
                        };
                    }

                    throw new Error('Invalid response from server');
                } catch (error) {
                    throw error;
                }
            },

            /**
             * Login user
             * @param {string} email - User's email
             * @param {string} password - User's password
             * @param {boolean} rememberMe - Whether to use localStorage (true) or sessionStorage (false)
             * @returns {Promise}
             */
            login: async function(email, password, rememberMe = false) {
                try {
                    const response = await request('/login', {
                        method: 'POST',
                        body: { email, password }
                    });

                    if (response.token && response.user) {
                        setToken(response.token, rememberMe);
                        setCurrentUser(response.user, rememberMe);
                        
                        // Dispatch login event
                        window.dispatchEvent(new CustomEvent('auth:login', {
                            detail: { user: response.user }
                        }));

                        return {
                            success: true,
                            token: response.token,
                            user: response.user
                        };
                    }

                    throw new Error('Invalid response from server');
                } catch (error) {
                    throw error;
                }
            },

            /**
             * Logout user
             * @returns {Promise}
             */
            logout: async function() {
                try {
                    await request('/logout', {
                        method: 'POST'
                    });
                } catch (error) {
                    // Continue with logout even if API call fails
                    console.error('Logout API error:', error);
                } finally {
                    removeToken();
                    
                    // Dispatch logout event
                    window.dispatchEvent(new CustomEvent('auth:logout'));
                }
            },

            /**
             * Get current authenticated user
             * @returns {Promise}
             */
            getUser: async function() {
                try {
                    const response = await request('/user');
                    setCurrentUser(response, getToken() ? localStorage.getItem(API_CONFIG.TOKEN_KEY) !== null : false);
                    return response;
                } catch (error) {
                    // If unauthorized, clear stored data
                    if (error.status === 401) {
                        removeToken();
                    }
                    throw error;
                }
            },

            /**
             * Check if user is authenticated
             * @returns {boolean}
             */
            isAuthenticated: function() {
                return getToken() !== null;
            },

            /**
             * Get stored user data
             * @returns {object|null}
             */
            getStoredUser: function() {
                return getCurrentUser();
            },

            /**
             * Get stored token
             * @returns {string|null}
             */
            getToken: function() {
                return getToken();
            }
        },

        /**
         * Visa Application Methods
         */
        visaApplication: {
            /**
             * Get all visa applications
             * @returns {Promise}
             */
            getAll: function() {
                return request('/visa-application');
            },

            /**
             * Get a specific visa application
             * @param {number} id - Application ID
             * @returns {Promise}
             */
            get: function(id) {
                return request(`/visa-application/${id}`);
            },

            /**
             * Create a new visa application
             * @param {object} data - Application data
             * @returns {Promise}
             */
            create: function(data) {
                return request('/visa-application', {
                    method: 'POST',
                    body: data
                });
            },

            /**
             * Update a visa application
             * @param {number} id - Application ID
             * @param {object} data - Updated data
             * @returns {Promise}
             */
            update: function(id, data) {
                return request(`/visa-application/${id}`, {
                    method: 'PUT',
                    body: data
                });
            },

            /**
             * Delete a visa application
             * @param {number} id - Application ID
             * @returns {Promise}
             */
            delete: function(id) {
                return request(`/visa-application/${id}`, {
                    method: 'DELETE'
                });
            }
        },

        /**
         * Package Methods
         */
        package: {
            /**
             * Get all packages
             * @returns {Promise}
             */
            getAll: function() {
                return request('/package');
            },

            /**
             * Get a specific package
             * @param {number} id - Package ID
             * @returns {Promise}
             */
            get: function(id) {
                return request(`/package/${id}`);
            },

            /**
             * Create a new package
             * @param {object} data - Package data
             * @returns {Promise}
             */
            create: function(data) {
                return request('/package', {
                    method: 'POST',
                    body: data
                });
            },

            /**
             * Update a package
             * @param {number} id - Package ID
             * @param {object} data - Updated data
             * @returns {Promise}
             */
            update: function(id, data) {
                return request(`/package/${id}`, {
                    method: 'PUT',
                    body: data
                });
            },

            /**
             * Delete a package
             * @param {number} id - Package ID
             * @returns {Promise}
             */
            delete: function(id) {
                return request(`/package/${id}`, {
                    method: 'DELETE'
                });
            }
        },

        /**
         * Visa Type Methods
         */
        visaType: {
            getAll: function() {
                return request('/visa-type');
            },
            get: function(id) {
                return request(`/visa-type/${id}`);
            },
            create: function(data) {
                return request('/visa-type', {
                    method: 'POST',
                    body: data
                });
            },
            update: function(id, data) {
                return request(`/visa-type/${id}`, {
                    method: 'PUT',
                    body: data
                });
            },
            delete: function(id) {
                return request(`/visa-type/${id}`, {
                    method: 'DELETE'
                });
            }
        },

        /**
         * Evisa Methods
         */
        evisa: {
            getAll: function() {
                return request('/evisa');
            },
            get: function(id) {
                return request(`/evisa/${id}`);
            },
            create: function(data) {
                return request('/evisa', {
                    method: 'POST',
                    body: data
                });
            },
            update: function(id, data) {
                return request(`/evisa/${id}`, {
                    method: 'PUT',
                    body: data
                });
            },
            delete: function(id) {
                return request(`/evisa/${id}`, {
                    method: 'DELETE'
                });
            }
        },

        /**
         * Generic request method for custom endpoints
         * @param {string} endpoint - API endpoint (e.g., '/test')
         * @param {object} options - Request options (method, body, headers, etc.)
         * @returns {Promise}
         */
        request: request,

        /**
         * Test API connection
         * @returns {Promise}
         */
        test: function() {
            return request('/test');
        }
    };

    // Export for module systems (if needed)
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = window.API;
    }
})();
