<?php
namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\AuthStoreRequest;
use App\Http\Requests\Auth\AuthUpdateRequest;

/**
 * @group
 * Auth Management
 */

class AuthController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api')->except(['login', 'register']);
    }

    /**
     * Login User
     * @response 201 
     * {
     *"token": "Sample Token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9....."
     *}
     * @response 401 "Error: Invalid Credentials"
     */
    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email' , 'password' => 'required']);

        if(!$token = Auth::attempt($credentials)) {
            return $this->error(['Error:' => 'Invalid Credentials'], 401);
        }

        return $this->response(['token' => $token]);
    }

     /**
     * Register User
     * @response 201 
     * {
     *{
     *"message": "User registered successfully"
     * }
     *}
     */
    public function register(AuthStoreRequest $request)
    {
        $credentials = $request->validated();

        $credentials['password'] = Hash::make($request->password);

        User::create($credentials);

        return $this->response(['message' => 'User registered successfully']);
    }

    /**
     * Get the authenticated User
     * @authenticated
     * @response 201
     * {
     *"result": {
     *   "id": 6,
     *  "name": "John Doe",
     *   "email": "user@gmail.com",
     *   "email_verified_at": null,
     *  "created_at": "2021-10-24T06:14:50.000000Z",
     *  "updated_at": "2021-10-24T06:14:50.000000Z"
     *}
     *}
     * @response 401  {"message": "Unauthenticated."}
     */
    public function me()
    {
        return $this->response(['result' => Auth::user()]);
    }

    /**
     * Logout User
     * @authenticated
     * @response 201
     * {
     *"message": "Logged Out successfully"
     *}
     */
    public function logout() 
    {
        Auth::logout();

        return $this->response(['message' => 'Logged Out successfully']);
    }
}
