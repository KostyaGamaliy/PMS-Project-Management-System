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

    class AuthController extends Controller
    {
        public function login(LoginRequest $request)
        {
            $deviceName = $request->device_name;

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['The provided credentials are incorrect.'],
                ]);
            }

            Auth::login($user);

            $user->tokens()
                ->where('name', $deviceName)
                ->delete();
            $token = $user->createToken($deviceName)->plainTextToken;

            return [
                'token' => $token,
                'user' => new UserResource($user),
            ];
        }

        public function register(RegisterRequest $request)
        {
            $deviceName = $request->device_name;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->tokens()
                ->where('name', $deviceName)
                ->delete();
            $token = $user->createToken($deviceName)->plainTextToken;

            return response([
                'token' => $token,
                'user' => new UserResource($user),
            ])->withHeaders([
                "Authorization" => "Bearer $token"
            ]);
        }

        public function logout(Request $request)
        {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Logged out']);
            }
            $user->tokens()->delete();
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json(['message' => 'Logged out']);
        }
    }
