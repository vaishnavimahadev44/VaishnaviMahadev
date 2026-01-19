
(function() {
    'use strict';

    
    const MONGODB_CONFIG = {
        
        apiKey: 'YOUR_API_KEY', 
        dataSource: 'YOUR_CLUSTER_NAME', 
        database: 'YOUR_DATABASE_NAME', 
        collection: 'YOUR_COLLECTION_NAME',
        
        baseUrl: 'https://data.mongodb-api.com/app/YOUR_APP_ID/endpoint/data/v1'
    };

    
    window.MongoDB = {
        config: MONGODB_CONFIG,

        /**
         * Initialize MongoDB connection with custom configuration
         * @param {object} config - Configuration object
         */
        init: function(config) {
            if (config) {
                Object.assign(this.config, config);
            }
        },

        /**
         * Make a request to MongoDB Atlas Data API
         * @param {string} action - Action to perform (find, insertOne, updateOne, deleteOne, etc.)
         * @param {object} filter - Filter query
         * @param {object} document - Document to insert/update
         * @param {object} options - Additional options
         * @returns {Promise}
         */
        _request: function(action, filter = {}, document = {}, options = {}) {
            const collection = options.collection || this.config.collection;
            const url = `${this.config.baseUrl}/action/${action}`;

            const requestBody = {
                dataSource: this.config.dataSource,
                database: this.config.database,
                collection: collection,
                ...options
            };

            // Add filter for find, update, delete operations
            if (filter && Object.keys(filter).length > 0) {
                if (action === 'find' || action === 'findOne') {
                    requestBody.filter = filter;
                } else if (action === 'updateOne' || action === 'updateMany') {
                    requestBody.filter = filter;
                    requestBody.update = document;
                } else if (action === 'deleteOne' || action === 'deleteMany') {
                    requestBody.filter = filter;
                }
            }

            // Add document for insert operations
            if (action === 'insertOne' || action === 'insertMany') {
                if (action === 'insertOne') {
                    requestBody.document = document;
                } else {
                    requestBody.documents = Array.isArray(document) ? document : [document];
                }
            }

            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'api-key': this.config.apiKey
                },
                body: JSON.stringify(requestBody)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.error || 'MongoDB request failed');
                    });
                }
                return response.json();
            })
            .then(data => {
                return data;
            })
            .catch(error => {
                console.error('MongoDB Error:', error);
                throw error;
            });
        },

        /**
         * Find documents
         * @param {object} filter - Query filter
         * @param {object} options - Options (collection, limit, sort, etc.)
         * @returns {Promise}
         */
        find: function(filter = {}, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection,
                limit: options.limit || 1000
            };
            
            if (options.sort) {
                requestOptions.sort = options.sort;
            }
            
            if (options.projection) {
                requestOptions.projection = options.projection;
            }

            return this._request('find', filter, {}, requestOptions)
                .then(result => result.documents || []);
        },

        /**
         * Find one document
         * @param {object} filter - Query filter
         * @param {object} options - Options (collection, projection, etc.)
         * @returns {Promise}
         */
        findOne: function(filter = {}, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection
            };
            
            if (options.projection) {
                requestOptions.projection = options.projection;
            }

            return this._request('findOne', filter, {}, requestOptions)
                .then(result => result.document || null);
        },

        /**
         * Insert one document
         * @param {object} document - Document to insert
         * @param {object} options - Options (collection)
         * @returns {Promise}
         */
        insertOne: function(document, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection
            };

            return this._request('insertOne', {}, document, requestOptions)
                .then(result => ({
                    insertedId: result.insertedId,
                    success: true
                }));
        },

        /**
         * Insert many documents
         * @param {array} documents - Array of documents to insert
         * @param {object} options - Options (collection)
         * @returns {Promise}
         */
        insertMany: function(documents, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection
            };

            return this._request('insertMany', {}, documents, requestOptions)
                .then(result => ({
                    insertedIds: result.insertedIds,
                    success: true
                }));
        },

        /**
         * Update one document
         * @param {object} filter - Query filter
         * @param {object} update - Update operations
         * @param {object} options - Options (collection, upsert)
         * @returns {Promise}
         */
        updateOne: function(filter, update, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection,
                upsert: options.upsert || false
            };

            return this._request('updateOne', filter, update, requestOptions)
                .then(result => ({
                    matchedCount: result.matchedCount,
                    modifiedCount: result.modifiedCount,
                    upsertedId: result.upsertedId,
                    success: true
                }));
        },

        /**
         * Update many documents
         * @param {object} filter - Query filter
         * @param {object} update - Update operations
         * @param {object} options - Options (collection)
         * @returns {Promise}
         */
        updateMany: function(filter, update, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection
            };

            return this._request('updateMany', filter, update, requestOptions)
                .then(result => ({
                    matchedCount: result.matchedCount,
                    modifiedCount: result.modifiedCount,
                    success: true
                }));
        },

        /**
         * Delete one document
         * @param {object} filter - Query filter
         * @param {object} options - Options (collection)
         * @returns {Promise}
         */
        deleteOne: function(filter, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection
            };

            return this._request('deleteOne', filter, {}, requestOptions)
                .then(result => ({
                    deletedCount: result.deletedCount,
                    success: true
                }));
        },

        /**
         * Delete many documents
         * @param {object} filter - Query filter
         * @param {object} options - Options (collection)
         * @returns {Promise}
         */
        deleteMany: function(filter, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection
            };

            return this._request('deleteMany', filter, {}, requestOptions)
                .then(result => ({
                    deletedCount: result.deletedCount,
                    success: true
                }));
        },

        /**
         * Count documents
         * @param {object} filter - Query filter
         * @param {object} options - Options (collection)
         * @returns {Promise}
         */
        count: function(filter = {}, options = {}) {
            const requestOptions = {
                collection: options.collection || this.config.collection
            };

            return this._request('count', filter, {}, requestOptions)
                .then(result => result.count || 0);
        },

        /**
         * Test MongoDB connection
         * @returns {Promise}
         */
        testConnection: function() {
            return this.findOne({}, { collection: this.config.collection })
                .then(() => {
                    console.log('✅ MongoDB connection successful');
                    return { success: true, message: 'Connection successful' };
                })
                .catch(error => {
                    console.error('❌ MongoDB connection failed:', error);
                    return { success: false, error: error.message };
                });
        }
    };

    // Export for use in modules
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = window.MongoDB;
    }
})();

