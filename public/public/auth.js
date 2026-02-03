// Real-time Authentication System
(function() {
    'use strict';

    const AUTH_KEY = 'admin_auth_token';
    const AUTH_EXPIRY = 'admin_auth_expiry';
    const SESSION_TIMEOUT = 30 * 60 * 1000; 
    const VALID_CREDENTIALS = {
        username: 'admin',
        password: 'admin123'
    };

    
    window.Auth = {
        
        login: function(username, password) {
            return new Promise(function(resolve, reject) {
                
                setTimeout(function() {
                    if (username === VALID_CREDENTIALS.username && 
                        password === VALID_CREDENTIALS.password) {
                        
                    
                        const token = btoa(username + ':' + Date.now());
                        const expiry = Date.now() + SESSION_TIMEOUT;
                        
                        try {
                            sessionStorage.setItem(AUTH_KEY, token);
                            sessionStorage.setItem(AUTH_EXPIRY, expiry.toString());
                            
                            
                            window.dispatchEvent(new CustomEvent('auth:login', {
                                detail: { username: username }
                            }));
                            
                            resolve({ success: true, token: token });
                        } catch (e) {
                            reject(new Error('Failed to store authentication. Please check if cookies/storage is enabled.'));
                        }
                    } else {
                        reject(new Error('Invalid username or password.'));
                    }
                }, 300); // Small delay for real-time feel
            });
        },

        /**
         * Logout function - clears session
         */
        logout: function() {
            try {
                sessionStorage.removeItem(AUTH_KEY);
                sessionStorage.removeItem(AUTH_EXPIRY);
                
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
            try {
                const token = sessionStorage.getItem(AUTH_KEY);
                const expiry = sessionStorage.getItem(AUTH_EXPIRY);
                
                if (!token || !expiry) {
                    return false;
                }
                
                // Check if session expired
                const now = Date.now();
                const expiryTime = parseInt(expiry, 10);
                
                if (now > expiryTime) {
                    // Session expired, clear it
                    this.logout();
                    return false;
                }
                
                // Extend session on activity (optional - for real-time session management)
                const timeRemaining = expiryTime - now;
                if (timeRemaining < SESSION_TIMEOUT / 2) {
                    // Extend session if less than half time remaining
                    sessionStorage.setItem(AUTH_EXPIRY, (Date.now() + SESSION_TIMEOUT).toString());
                }
                
                return true;
            } catch (e) {
                return false;
            }
        },

        /**
         * Get current user info
         * @returns {object|null}
         */
        getUser: function() {
            if (this.isAuthenticated()) {
                return {
                    username: VALID_CREDENTIALS.username,
                    isAdmin: true
                };
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
         * @returns {number}
         */
        getSessionTimeRemaining: function() {
            try {
                const expiry = sessionStorage.getItem(AUTH_EXPIRY);
                if (!expiry) return 0;
                
                const expiryTime = parseInt(expiry, 10);
                const remaining = expiryTime - Date.now();
                return remaining > 0 ? remaining : 0;
            } catch (e) {
                return 0;
            }
        }
    };

    // Real-time session monitoring
    if (typeof window !== 'undefined') {
        // Check authentication status periodically
        setInterval(function() {
            if (window.Auth && !window.Auth.isAuthenticated()) {
                // If we're on a protected page and not authenticated, redirect
                const currentPath = window.location.pathname;
                if (currentPath.includes('Admin') && !currentPath.includes('login')) {
                    window.Auth.requireAuth(window.location.href);
                }
            }
        }, 60000); // Check every minute

        // Listen for storage events (for multi-tab real-time sync)
        window.addEventListener('storage', function(e) {
            if (e.key === AUTH_KEY || e.key === AUTH_EXPIRY) {
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
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && window.Auth) {
                // Tab became visible, check auth status
                if (!window.Auth.isAuthenticated()) {
                    const currentPath = window.location.pathname;
                    if (currentPath.includes('Admin') && !currentPath.includes('login')) {
                        window.Auth.requireAuth(window.location.href);
                    }
                }
            }
        });
    }
})();
