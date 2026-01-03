<?php 
  

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\VisaType;

class VisaTypeController extends Controller
{  
    /**
     * POST /api/visa-type
     * Store a new visa type
     */
    public function store(Request $request)
    {
      
        // Validate incoming request
        $validated = $request->validate([
            'text'  => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        // Save to database
        $visaType = VisaType::create($validated);

        // Return API response
        return response()->json([
            'status'  => 'success',
            'message' => 'visa-type record stored successfully',
            'data'    => $visaType
        ], 201);
    }
        /**
         * GET /api/visa-type
         * List all visa type
         */
        public function index()
        {
            $visaType = VisaType::all();
            return response()->json($visaType);
        }
         
        /**
         * GET /api/visa-type/{id}
         * Show a single visa type
         */
        public function show($id)
        {
            $visaType = VisaType::findOrFail($id);
            return response()->json($visaType);
        }
    
        /**
         * PUT/PATCH /api/visa-type/{id}
         * Update an existing visa type
         */
        public function update(Request $request, $id)
        {
            $visaType = VisaType::findOrFail($id);
    
            $validated = $request->validate([
                'text'  => 'sometimes|string|max:255',
                'value' => 'sometimes|string|max:255',
                'price' => 'sometimes|numeric|min:0',    
            ]);
    
            $visaType->update($validated);
    
            return response()->json([
                'status'  => 'success',
                'message' => 'visa-type record updated successfully',
                'data'    => $visaType
            ]);
        }
        
        /**
         * DELETE /api/visa-type/{id}
         * delete a visa-type
         */
        public function destroy($id)
        {
            $visaType = VisaType::findOrFail($id);
            $visaType->delete();
    
            return response()->json([
                'status'  => 'success',
                'message' => 'visa-type record deleted successfully'
            ]);
        }
}