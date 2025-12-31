import express from 'express';
import { testConnection, getUsers, createUser, updateUser, deleteUser } from '../controllers/userController.js';
import {
    deleteApplication,
    deleteCategory,
    deleteDepartment,
    deleteEmployee,
    deleteProject,
    deleteTask,
    deleteDocument,
    deleteComment,
    deleteNotification,
    deleteRole,
    deletePermission,
    deleteClient,
    deleteVendor,
    deleteAsset,
    deleteAuditLog
} from '../controllers/deleteController.js';

const router = express.Router();

router.get('/test', (req, res) => {
    res.json({ 
        message: 'API is working!',
        timestamp: new Date().toISOString()
    });
});


router.get('/users', getUsers);
router.post('/users', createUser);
router.put('/users/:id', updateUser);
router.delete('/users/:id', deleteUser);

router.delete('/applications/:id', deleteApplication);
router.delete('/categories/:id', deleteCategory);
router.delete('/departments/:id', deleteDepartment);
router.delete('/employees/:id', deleteEmployee);
router.delete('/projects/:id', deleteProject);
router.delete('/tasks/:id', deleteTask);
router.delete('/documents/:id', deleteDocument);
router.delete('/comments/:id', deleteComment);
router.delete('/notifications/:id', deleteNotification);
router.delete('/roles/:id', deleteRole);
router.delete('/permissions/:id', deletePermission);
router.delete('/clients/:id', deleteClient);
router.delete('/vendors/:id', deleteVendor);
router.delete('/assets/:id', deleteAsset);
router.delete('/audit-logs/:id', deleteAuditLog);

export default router;

