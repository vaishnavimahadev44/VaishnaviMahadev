<?php 
  

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ClientVisa;

class PostController extends Controller
{  public function storeVisa(Request $request)
    {
        // header("content-Type:application/json");
        // if($_SERVER['REQUEST_METHOD']!='POST') {
        //     http_response_code(405);
        //     echo json_encode(['error'=>'Method not allowed']);
        //     exit;
        // }
        // $data = json_decode(file_get_contents("php://input"), true);
        // if(!$data) {
        //     http_response_code(400);
        //     echo json_encode(['error'=>'Invalid JSON']);
        //     exit;
        // }

        
        // Validate incoming request
        $validated = $request->validate([
            'passport_number' => 'required|string',
            'full_name'       => 'required|string',
            'nationality'     => 'required|string',
            'visa_type'       => 'required|string',
            'issue_date'      => 'required|date',
            'expiry_date'     => 'required|date',
        ]);

        // Save to database
        $visa = ClientVisa::create($validated);

        // Return API response
        return response()->json([
            'status'  => 'success',
            'message' => 'Visa record stored successfully',
            'data'    => $visa
        ], 201);
    }

}