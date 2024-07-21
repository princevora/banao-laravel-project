<?php

namespace App\Http\Controllers\Users\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Middleware\ApiAuthentication;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Add task Validator rules to validate request
     * 
     * @var array<string, string | array>
     */
    private array $addTaskRules = [
        'task' => 'required|string',
        'user_id' => 'required|exists:users,id',
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse|\Illuminate\Support\MessageBag
     */
    public function addTask(Request $request): Response | MessageBag
    {
        // Make validator
        $validator = Validator::make($request->all(), $this->addTaskRules);

        // Check if the validator fails, If fails then return message bag
        if ($validator->fails()) return $validator->getMessageBag();

        /**
         * @var array<string, string | int>  $validatorData
         */
        $validatorData = $validator->getData();

        try {
            // Create A task in database
            $task = Task::create([
                'user_id' => $validatorData['user_id'],
                'task' => $validatorData['task'],
            ]);

            // return the response
            return response()
                ->json([
                    'task'    => $task,
                    'status'  => 1,
                    'message' => 'successfully created a task'
                ]);
        } catch (\Throwable $th) {

            // Send error response if the server unable to add the task
            return response()
                ->json([
                    'status' => 0,
                    'message' => "Unable to add task. Message: {$th->getMessage()}"
                ]);
        }
    }

    public function updateStatus(Request $request, ApiAuthentication $api)
    {
        // Get bearer token from request headers.
        $apiKey = $request->bearerToken();

        // Make update Status validator.
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|exists:tasks,id|integer',
            'status'  => ['required', 'string', new Enum(StatusEnum::class)]
        ],[
            'status' => 'The selected status is invalid. It should be either pending Or done'
        ]);

        // Check if the validator fails, If fails then return message bag
        if ($validator->fails()) return $validator->getMessageBag();

        /**
         * @var int $task_id
         */
        $task_id = $request->task_id;

        /**
         * @var string $status
         */
        $status = $request->status;

        // Get the user's api token using relations and prevent errors.
        $task = @Task::query()
                    ->with('user')
                    ->where('id', $task_id)
                    ->first();

        $userApiKey = $task
                    ->user
                    ->api_token;

        // Validate if the taskid request belongs to correct user.
        if($userApiKey && $apiKey !== $userApiKey){
            return $api->sendUnauthorizedResponse("The api key is invalid for the task id");
        }

        // Check if the user's task is already same as the provided status to prevent load on database.
        if($task->status == $status){
            return $this->sendResponse(1, "Updating aborted because, the task status is already {$status}");
        }

        // Update the task status..
        try {
            Task::where('id', $task_id)
                ->update([
                    'status' => $status
                ]);

            // Send success response
            return $this->sendResponse(1, "Marked task as {$status}", 200);
        } catch (\Throwable $th) {

            // Send the error Response.
            $this->sendResponse(0, 'Unable to update the task. Try again later', 422);
        }
    }

    /**
     * @param int $successStatus
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    private function sendResponse(int $successStatus, string $message, ?int $statusCode = 200)
    {
        return response()
                ->json([
                    'status' => $successStatus,
                    'message' => $message
                ])
                ->setStatusCode($statusCode);
    }
}
