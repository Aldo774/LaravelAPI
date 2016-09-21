<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Hash;

class AuthController extends Controller
{
    public function authenticate(Request $request) {
      // Get only email and password from request
      $credentials = $request->only('email', 'password');

      // Get user by email
      $company = Company::where('email', $credentials['email'])->first();

      // Validate Company
      if(!$company) {
        return response()->json([
          'error' => 'Invalid credentials'
        ], 401);
      }

      // Validate Password
      if ($credentials['password'] != $company->password) {
          return response()->json([
            'error' => 'Invalid credentials'
          ], 401);
      }

      // Generate Token
      $token = JWTAuth::fromUser($company);

      // Get expiration time
      $objectToken = JWTAuth::setToken($token);
      $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');

      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => JWTAuth::decode()->get('exp')
      ]);
    }
}