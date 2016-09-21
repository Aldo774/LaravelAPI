<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Hash;
use Validator;

use App\Http\Requests\AuthenticateRequest;

class AuthController extends Controller
{
    public function authenticate(Request $request) {
      // TODO: authenticate JWT
      $credentials = $request->only('email', 'password');

      // dd($request->all());

      // Validate credentials
      $validator = Validator::make($credentials, [
          'password' => 'required',
          'email' => 'required'
      ]);

      if($validator->fails()) {
          return response()->json([
              'message'   => 'Invalid credentials',
              'errors'    => $validator->errors()->all()
          ], 422);
      }

      // Get user by email
      $company = Company::where('email', $credentials['email'])->first();

      // Validate Company
      if(!$company) {
        return response()->json([
          'error' => 'Invalid credentials'
        ], 422);
      }

      // Validate Password
      if ($credentials['password'] != $company->password) {
          return response()->json([
            'error' => 'Invalid credentials'
          ], 422);
      }

      // Generate Token
      $token = JWTAuth::fromUser($company);

      // Get expiration time
      $objectToken = JWTAuth::setToken($token);
      $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');

      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => $expiration
      ]);
    }
}
