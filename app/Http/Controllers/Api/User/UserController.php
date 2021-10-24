<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\AuthUpdateRequest;

/**
 * @group Auth Management
 */
class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

     /**
     * Update User's Password
     * @authenticated
     * @response 201
     * {
     *"message": "Password updated successfully"
     *}
     */
    public function __invoke(Request $request)
    {
        $user = User::findOrFail(auth()->id());

        $credentials = $request->validate(['password' => 'required|min:6|max:12']);

        $credentials['password'] = Hash::make($request->password);

        $user->update($credentials);

        return $this->response(['message' => 'Password updated successfully']);
    }
}
