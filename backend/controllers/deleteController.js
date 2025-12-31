import { pool } from '../config/database.js';

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
            message: 'User deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete an application
export const deleteApplication = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM applications WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Application not found'
            });
        }

        await pool.query('DELETE FROM applications WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Application deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a category
export const deleteCategory = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM categories WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Category not found'
            });
        }

        await pool.query('DELETE FROM categories WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Category deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a department
export const deleteDepartment = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM departments WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Department not found'
            });
        }

        await pool.query('DELETE FROM departments WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Department deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete an employee
export const deleteEmployee = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM employees WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Employee not found'
            });
        }

        await pool.query('DELETE FROM employees WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Employee deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a project
export const deleteProject = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM projects WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Project not found'
            });
        }

        await pool.query('DELETE FROM projects WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Project deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a task
export const deleteTask = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM tasks WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Task not found'
            });
        }

        await pool.query('DELETE FROM tasks WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Task deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a document
export const deleteDocument = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM documents WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Document not found'
            });
        }

        await pool.query('DELETE FROM documents WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Document deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a comment
export const deleteComment = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM comments WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Comment not found'
            });
        }

        await pool.query('DELETE FROM comments WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Comment deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a notification
export const deleteNotification = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM notifications WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Notification not found'
            });
        }

        await pool.query('DELETE FROM notifications WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Notification deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a role
export const deleteRole = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM roles WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Role not found'
            });
        }

        await pool.query('DELETE FROM roles WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Role deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a permission
export const deletePermission = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM permissions WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Permission not found'
            });
        }

        await pool.query('DELETE FROM permissions WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Permission deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a client
export const deleteClient = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM clients WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Client not found'
            });
        }

        await pool.query('DELETE FROM clients WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Client deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete a vendor
export const deleteVendor = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM vendors WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Vendor not found'
            });
        }

        await pool.query('DELETE FROM vendors WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Vendor deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete an asset
export const deleteAsset = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM assets WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Asset not found'
            });
        }

        await pool.query('DELETE FROM assets WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Asset deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

// Delete an audit log
export const deleteAuditLog = async (req, res, next) => {
    try {
        const { id } = req.params;
        const [existing] = await pool.query('SELECT * FROM audit_logs WHERE id = ?', [id]);
        
        if (existing.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Audit log not found'
            });
        }

        await pool.query('DELETE FROM audit_logs WHERE id = ?', [id]);

        res.json({
            success: true,
            message: 'Audit log deleted successfully',
            data: { id: parseInt(id) }
        });
    } catch (error) {
        next(error);
    }
};

