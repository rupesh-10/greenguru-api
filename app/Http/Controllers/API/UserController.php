<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use App\Services\UserService;



class UserController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function register(Request $request)
    {
        $response =  $this->userService->register($request);
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $response = $this->userService->login($request);
        return response()->json($response);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => true, 'message' => "User logout Successfully!"]);
    }

    public function recommend($diseaseName)
    {
        $recommendation = Recommendation::where('disease_name', $diseaseName)->first();
        if ($recommendation) {
            return response()->json(['status' => true, 'message' => $recommendation->cure]);
        }
        return response()->json(['status' => true, 'message' => "Currently, we don't have a cure for this disease. Stay tuned for updates"]);
    }
}
