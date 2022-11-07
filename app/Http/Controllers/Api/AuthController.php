<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 'failure',
                'status_code' => 400,
                'errors' => $validator->errors(),
            ];
            return response()->json($response, 400);
        } else {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
            if ($user) {
                $response = [
                    'user' => $user,
                ];
                return response($response, 200);
            }
        }
    }



/**
     * @OA\Post(
     * path="/api/login",
     * tags={"Auth"},
     * summary="user login",
     * description="A user enters login details",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"username","password"},
     *               @OA\Property(property="username", type="required|string"),
     *               @OA\Property(property="password", type="required|string")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="login successful",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="login fails",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 'failure',
                'status_code' => 400,
                'message' => 'Bad Request',
                'errors' => $validator->errors(),
            ];

            return response()->json($response, 400);
        }

        $validator = $validator->validated();

        // check username
        $user = User::where('username', $validator['username'])->first();


        // check password
        if (!$user || !Hash::check($validator['password'], $user->password)) {
            return response([
                'message' => 'YOU ARE NOT SUPPOSE TO BE HERE'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;


        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
