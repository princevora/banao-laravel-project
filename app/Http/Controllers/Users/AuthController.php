<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\WithToastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use WithToastr;

    /**
     * @param \Illuminate\Http\Request $request
     * @return ?\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the data
        Validator::validate(
            $request->all(),
            [
                'email'    => 'required|email|exists:users,email',
                'password' => 'required|min:8',
            ],
            [
                'email.exists' => 'Please provide valid email address, we couldnt found this email'
            ]
        );

        // Find the User 
        $user = User::query()
            ->where('email', $request->email)
            ->firstOrFail();

        // Create credentials array for Auth attempt
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        // Check if the password is incorrect or not
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['password' => 'Incorrect Password Provided']);
        } 
        // Else check if the Auth atteampt succeed
        elseif (Auth::attempt($credentials, $request->remember)) {

            // Redirect the user to the dashboad.
            return redirect()->route('dashboard')->with('toastr', [
                'message' => 'Successfully logged in',
                'type'    => 'success'
            ]);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function register(Request $request)
    {
        // Validate data for registration
        Validator::validate(
            $request->all(),
            [
                'name'     => 'required|regex:/^[a-zA-Z\s]+$/',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:8',
            ],
            [
                'name.regex' => 'The name field must only contain letters and spaces.',
            ]
        );

        // Destruct the properties
        [
            'name'     => $name,
            'email'    => $email,
            'password' => $password
        ] = $request->all();

        // Make the hashed password from the raw password
        $hashedPassword = Hash::make($password);
        $api_token      = Str::random(50);

        try {
            // Try to save the user in the database
            User::query()->create([
                'name'      => $name,
                'email'     => $email,
                'password'  => $hashedPassword,

                // Assign user a api key, for using api
                'api_token' => $api_token
            ])->saveOrFail();

            // Create credentials
            $credentials = [
                'email'    => $email,
                'password' => $password
            ];

            // Authentiaction attempt.
            if (Auth::attempt($credentials, true)) {
                return redirect()->route('user.dashboard');
            }
        } catch (\Throwable $th) {
            // Send error toast
            $this->setType('error')
                 ->setMessage("Unable to register user")
                 ->send();

            throw ValidationException::withMessages(['other' => "Unable to register. {$th->getMessage()}"]);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        // Logout The user
        Auth::logout();

        // Redirect to login route
        return redirect()->route('login');
    }
}
