import { pool } from '../config/database.js'

// Get all users
export const getUsers = async (req, res, next) => {
    try {
        const [rows] = await pool.query('SELECT * FROM users ORDER BY id DESC');
        res.json({
            success: true,
            count: rows.length,
            data: rows
        });
    } catch (error) {
        next(error);
    }
};

// Create a new user
export const createUser = async (req, res, next) => {
    try {
        const { name, email, password } = req.body;

        if (!name || !email) {
            return res.status(400).json({
                success: false,
                message: 'Name and email are required'
            });
        }

        const [result] = await pool.query(
            'INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())',
            [name, email, password || null]
        );

        const [newUser] = await pool.query('SELECT * FROM users WHERE id = ?', [result.insertId]);

        res.status(201).json({
            success: true,
            message: 'User created successfully',
            data: newUser[0]
        });
    } catch (error) {
        if (error.code === 'ER_DUP_ENTRY') {
            return res.status(409).json({
                success: false,
                message: 'Email already exists'
            });
        }
        next(error);
    }
};

// Update a user
export const updateUser = async (req, res, next) => {
    try {
        const { id } = req.params;
        const { name, email, password } = req.body;

        // Check if user exists
        const [existingUser] = await pool.query('SELECT * FROM users WHERE id = ?', [id]);
        
        if (existingUser.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'User not found'
            });
        }

        // Build update query dynamically
        const updates = [];
        const values = [];

        if (name) {
            updates.push('name = ?');
            values.push(name);
        }
        if (email) {
            updates.push('email = ?');
            values.push(email);
        }
        if (password) {
            updates.push('password = ?');
            values.push(password);
        }

        if (updates.length === 0) {
            return res.status(400).json({
                success: false,
                message: 'No fields to update'
            });
        }

        updates.push('updated_at = NOW()');
        values.push(id);

        await pool.query(
            `UPDATE users SET ${updates.join(', ')} WHERE id = ?`,
            values
        );

        const [updatedUser] = await pool.query('SELECT * FROM users WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'User updated successfully',
            data: updatedUser[0]
        });
    } catch (error) {
        if (error.code === 'ER_DUP_ENTRY') {
            return res.status(409).json({
                success: false,
                message: 'Email already exists'
            });
        }
        next(error);
    }
};

// Delete a user
export const deleteUser = async (req, res, next) => {
    try {
        const { id } = req.params;

        
        const [existingUser] = await pool.query('SELECT * FROM users WHERE id = ?', [id]);
        
        if (existingUser.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'User not found'
            });
        }

        await pool.query('DELETE FROM users WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'User deleted successfully'
        });
    } catch (error) {
        next(error);
    }
};

