<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * $rules Wil prevent duplication of code
     * 
     * @var array $rules
     */
    private $rules = [
        /**
         * As our name can contain the surname and the first or lastname with space
         * We will validate it with spaces and latters only 
         * Other characters will be declined
         */
        
        'name'     => 'required|regex:/^[a-zA-Z\s]+$/', //Latters only and requird field
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:8',
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function login(Request $request)
    {
        Validator::validate(
            $request->all(), //Set the data to request'all data
            array_shift($this->rules) //Remove the name field and validate the email and password field
        );
    }

    public function register(Request $request)
    {
        Validator::validate(
            $request->all(),
            $this->rules, // Validate the all rules in the rules property

            // Regex custom field
            [
                'name' => 'The name field must only contain latters and space',
            ],
        );

        try {
            //code...
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['other' => "Unable to register. {$th->getMessage()}"]);
        }
    }
}
