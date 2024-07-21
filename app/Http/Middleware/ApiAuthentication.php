<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * Get the API key from the request's Authorization header.
         * 
         * @var string
         */
        $apiKey = $request->bearerToken();

        /**
         * Get the user ID from the request.
         * 
         * @var int
         */
        $userId = $request->input('user_id');

        // Check if the API key is provided.
        if (!$apiKey) {
            return $this->sendUnauthorizedResponse('Please Provide Api Key');
        }

        $validateUserId = $request->routeIs('todo.add');

        if ($validateUserId && !$userId) {
            // Check if the user ID is provided.
            return $this->sendUnauthorizedResponse('Please Provide user id');
        }

        if ($validateUserId) {
            /**
             * Validate the API key and user ID combination
             * This will help to validate and to prevent any other person to use this api
             */
            $userApiKey = User::where('id', $userId)->where('api_token', $apiKey)->exists();

            // If the combination is invalid, return an unauthorized response.
            if (!$userApiKey) {
                return $this->sendUnauthorizedResponse();
            }
        }

        // Proceed with the request if the API key and user ID are valid.
        return $next($request);
    }

    /**
     * Returns the unauthorized response to user 
     * 
     * @param mixed $message Assigns what to return in the messge
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendUnauthorizedResponse($message = "Invalid API key or User ID Provided"): Response
    {
        // Send the json response
        return response()->json([
            'status'  => 0, //Set the status to 0 as it is failed
            'message' => $message //Send the message
        ])->setStatusCode(401); //set the status code to unauthorized
    }
}
