/**
 * Authentication System - Integrated with Laravel Backend API
 * Requires api.js to be loaded first
 */

(function() {
    'use strict';

    // Check if API service is available
    if (typeof window.API === 'undefined') {
        console.error('API service (api.js) must be loaded before auth.js');
    }

    window.Auth = {
        /**
         * Login function - uses backend API
         * @param {string} email - User's email (or username for backward compatibility)
         * @param {string} password - User's password
         * @param {boolean} rememberMe - Whether to use localStorage (true) or sessionStorage (false)
         * @returns {Promise}
         */
        login: function(emailOrUsername, password, rememberMe = false) {
            return new Promise(async function(resolve, reject) {
                // Check if API service is available
                if (typeof window.API === 'undefined') {
                    reject(new Error('API service is not available. Please ensure api.js is loaded.'));
                    return;
                }

                try {
                    // Use email if provided, otherwise treat as email (for backward compatibility)
                    const email = emailOrUsername.includes('@') ? emailOrUsername : emailOrUsername + '@example.com';
                    
                    // Call backend API
                    const result = await window.API.auth.login(email, password, rememberMe);
                    
                    resolve({
                        success: true,
                        token: result.token,
                        user: result.user
                    });
                } catch (error) {
                    // Handle API errors
                    let errorMessage = 'Login failed. Please try again.';
                    
                    if (error.status === 401) {
                        errorMessage = 'Invalid email or password.';
                    } else if (error.message) {
                        errorMessage = error.message;
                    }
                    
                    reject(new Error(errorMessage));
                }
            });
        },

        /**
         * Logout function - uses backend API
         */
        logout: async function() {
            try {
                // Call backend API if available
                if (typeof window.API !== 'undefined' && window.API.auth.isAuthenticated()) {
                    try {
                        await window.API.auth.logout();
                    } catch (error) {
                        console.error('Logout API error:', error);
                        // Continue with local logout even if API call fails
                    }
                }
                
                // Dispatch logout event
                window.dispatchEvent(new CustomEvent('auth:logout'));
                
                // Redirect to login
                window.location.href = 'login.html';
            } catch (e) {
                console.error('Logout error:', e);
                window.location.href = 'login.html';
            }
        },

        /**
         * Check if user is authenticated
         * @returns {boolean}
         */
        isAuthenticated: function() {
            if (typeof window.API === 'undefined') {
                return false;
            }
            return window.API.auth.isAuthenticated();
        },

        /**
         * Get current user info
         * @returns {object|null}
         */
        getUser: function() {
            if (typeof window.API === 'undefined') {
                return null;
            }
            
            if (this.isAuthenticated()) {
                const user = window.API.auth.getStoredUser();
                if (user) {
                    return {
                        username: user.name || user.email,
                        email: user.email,
                        name: user.name,
                        id: user.id,
                        isAdmin: user.is_admin || false
                    };
                }
            }
            return null;
        },

        /**
         * Require authentication - redirects to login if not authenticated
         * @param {string} redirectUrl - URL to redirect to after login
         */
        requireAuth: function(redirectUrl) {
            if (!this.isAuthenticated()) {
                const loginUrl = redirectUrl 
                    ? 'login.html?next=' + encodeURIComponent(redirectUrl)
                    : 'login.html';
                window.location.href = loginUrl;
                return false;
            }
            return true;
        },

        /**
         * Get session time remaining in milliseconds
         * Note: Laravel Sanctum tokens don't expire by default, but this can be configured
         * @returns {number}
         */
        getSessionTimeRemaining: function() {
            // Sanctum tokens don't have expiration by default
            // Return a large number to indicate valid session
            if (this.isAuthenticated()) {
                return 999999999; // Large number indicating valid session
            }
            return 0;
        }
    };

    // Real-time session monitoring
    if (typeof window !== 'undefined') {
        // Check authentication status periodically
        setInterval(async function() {
            if (window.Auth && !window.Auth.isAuthenticated()) {
                // If we're on a protected page and not authenticated, redirect
                const currentPath = window.location.pathname;
                if (currentPath.includes('Admin') && !currentPath.includes('login')) {
                    window.Auth.requireAuth(window.location.href);
                }
            } else if (window.Auth && window.Auth.isAuthenticated() && typeof window.API !== 'undefined') {
                // Verify token is still valid by checking with backend
                try {
                    await window.API.auth.getUser();
                } catch (error) {
                    // Token is invalid, logout
                    if (error.status === 401) {
                        window.Auth.logout();
                    }
                }
            }
        }, 60000); // Check every minute

        // Listen for storage events (for multi-tab real-time sync)
        window.addEventListener('storage', function(e) {
            if (e.key === 'auth_token' || e.key === 'auth_user') {
                // Auth state changed in another tab
                if (!window.Auth.isAuthenticated()) {
                    const currentPath = window.location.pathname;
                    if (currentPath.includes('Admin') && !currentPath.includes('login')) {
                        window.location.href = 'login.html';
                    }
                }
            }
        });

        // Monitor visibility changes (check auth when tab becomes visible)
        document.addEventListener('visibilitychange', async function() {
            if (!document.hidden && window.Auth) {
                // Tab became visible, check auth status
                if (!window.Auth.isAuthenticated()) {
                    const currentPath = window.location.pathname;
                    if (currentPath.includes('Admin') && !currentPath.includes('login')) {
                        window.Auth.requireAuth(window.location.href);
                    }
                } else if (typeof window.API !== 'undefined') {
                    // Verify token is still valid
                    try {
                        await window.API.auth.getUser();
                    } catch (error) {
                        if (error.status === 401) {
                            window.Auth.logout();
                        }
                    }
                }
            }
        });
    }
})();
