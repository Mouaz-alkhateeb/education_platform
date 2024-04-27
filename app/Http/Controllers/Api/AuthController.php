<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function __construct(private UserService $userService)
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register', 'create_user']]);
    }

    public function login(Request $request)
    {

        try {

            if ($request->query()) {
                return response()->json(['message' => 'Query parameters are not allowed']);
            } else {
                $validateUser = Validator::make(
                    $request->all(),
                    [
                        'email' => 'required|email',
                        'password' => 'required'
                    ]
                );

                if ($validateUser->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 401);
                }

                if (!Auth::attempt($request->only(['email', 'password']))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Email & Password does not match with our record.',
                    ], 401);
                }

                $user = User::where('email', $request->email)->first();

                return response()->json([
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'user' => UserResource::make($user),
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function create_user(CreateUserRequest $request)
    {
        $createdData = $this->userService->create_user($request->validated());
        $returnData = UserResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User successfully signed out']);
    }
}
