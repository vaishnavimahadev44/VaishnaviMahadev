<?php 
  

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TemplateBuying;

class TemplateBuyingController extends Controller
{  
    /**
     * POST /api/template-buying
     * Store a new template
     */
    public function store(Request $request)
    {
      
        // Validate incoming request
        $validated = $request->validate([
            'template_name'        => 'required|string|max:255',
            'template_price'       => 'required|numeric|min:0',
            'description'          => 'nullable|string'
        ]);

        // Save to database
        $template = TemplateBuying::create($validated);

        // Return API response
        return response()->json([
            'status'  => 'success',
            'message' => 'template record stored successfully',
            'data'    => $template
        ], 201);
    }
        /**
         * GET /api/template-buying
         * List all template-buying
         */
        public function index()
        {
            $template = TemplateBuying::all();
            return response()->json($template);
        }
         
        /**
         * GET /api/template-buying/{id}
         * Show a single template
         */
        public function show($id)
        {
            $template = TemplateBuying::findOrFail($id);
            return response()->json($template);
        }
    
        /**
         * PUT/PATCH /api/template-buying/{id}
         * Update an existing template
         */
        public function update(Request $request, $id)
        {
            $template = TemplateBuying::findOrFail($id);
    
            $validated = $request->validate([
                'template_name'        => 'sometimes|string|max:255',
                'template_price'       => 'sometimes|numeric|min:0',  
                'description'          => 'nullable|string'  
            ]);
    
            $template->update($validated);
    
            return response()->json([
                'status'  => 'success',
                'message' => 'template record updated successfully',
                'data'    => $template
            ]);
        }
        
        /**
         * DELETE /api/template-buying/{id}
         * delete a template
         */
        public function destroy($id)
        {
            $template = TemplateBuying::findOrFail($id);
            $template->delete();
    
            return response()->json([
                'status'  => 'success',
                'message' => 'template record deleted successfully'
            ]);
        }
}