<?php
namespace App\Http\Controllers;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class ApplicationController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Jobs API',
            'status' => 'Connected'
        ]);
    }
    public function redirect()
    {
        return redirect('api');
    }
    public function unauthorized()
    {
        return response()->json(['Unauthorized'], 401);
    }
    public function authenticate(Requests $request)
    {
        $credentials = $request->only('email', 'password');
    }
}