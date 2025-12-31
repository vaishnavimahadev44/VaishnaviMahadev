<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Application;
use App\Models\Category;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use App\Models\Document;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\Asset;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DeleteController extends Controller
{
    
    public function deleteUser($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    
    public function deleteApplication($id): JsonResponse
    {
        try {
            $application = Application::findOrFail($id);
            $application->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Application deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    
    public function deleteCategory($id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

   
    public function deleteDepartment($id): JsonResponse
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Department deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    
    public function deleteEmployee($id): JsonResponse
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    
    public function deleteTask($id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

       public function deleteDocument($id): JsonResponse
    {
        try {
            $document = Document::findOrFail($id);
            $document->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Document deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Document not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete a comment
     */
    public function deleteComment($id): JsonResponse
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete a notification
     */
    public function deleteNotification($id): JsonResponse
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete a role
     */
    public function deleteRole($id): JsonResponse
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete a permission
     */
    public function deletePermission($id): JsonResponse
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete a client
     */
    public function deleteClient($id): JsonResponse
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Client deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete a vendor
     */
    public function deleteVendor($id): JsonResponse
    {
        try {
            $vendor = Vendor::findOrFail($id);
            $vendor->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Vendor deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete an asset
     */
    public function deleteAsset($id): JsonResponse
    {
        try {
            $asset = Asset::findOrFail($id);
            $asset->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Asset deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Asset not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete an audit log
     */
    public function deleteAuditLog($id): JsonResponse
    {
        try {
            $auditLog = AuditLog::findOrFail($id);
            $auditLog->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Audit log deleted successfully',
                'data' => ['id' => $id]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Audit log not found or could not be deleted',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}

