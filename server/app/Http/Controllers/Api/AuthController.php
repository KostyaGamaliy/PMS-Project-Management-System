<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\LoginRequest;
    use App\Http\Requests\RegisterRequest;
    use App\Http\Resources\UserResource;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\ValidationException;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

    class AuthController extends Controller
    {
        public function login(LoginRequest $request)
        {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = $request->user();
                $deviceName = $request->device_name;

                Auth::login($user);

                $user->tokens()
                    ->where('name', $deviceName)
                    ->delete();
                $token = $user->createToken($deviceName)->plainTextToken;

                return [
                    'token' => $token,
                    'user' => new UserResource($user),
                ];
            } else {
                $response = [
                    'message' => 'Невірний емейл або пароль'
                ];
                return response()->json($response, 400);
            }
        }

        public function register(RegisterRequest $request)
        {
            $deviceName = $request->device_name;

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            Auth::login($user);

            $token = $user->createToken($deviceName)->plainTextToken;

            return response([
                'token' => $token,
                'user' => new UserResource($user),
            ]);
        }

        public function logout(Request $request)
        {
            Session::flush();
            Auth::logout();

            return response()->json([
                'message' => 'Successfully logged out'
            ], 200);
        }
    }
