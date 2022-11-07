<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

     /**
     * @OA\Post(
     * path="/api/task-create",
     * tags={"Tasks"},
     * summary="create tasks for a project",
     * description="Admin create tasks for a project",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"task_name"},
     *               @OA\Property(property="task_name", type="required|string"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Project Created",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="fails",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function createTask(Request $request)
    {
        $addTask = new Task;
        $addTask->project_id = $request->project_id;
        $addTask->task_name = $request->task_name;
        $addTask->save();

        $response = [
            'message' => 'Project Created'
        ];

        return response($response, 201);
    }




     /**
     * @OA\Get(
     *      path= "api/all-tasks",
     *      tags={"Tasks"},
     *      summary="Get all Tasks",
     *      description="Get all Tasks",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/ProjectResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function getAllTask(Request $request)
    {
        $task = Task::all()->paginate(10);
        return response()->json($task, 200);
    }




      /**
     * @OA\Get(
     *      path= "api/user-tasks/{$task_id}",
     *      tags={"Tasks"},
     *      summary="Get each Tasks",
     *      description="Get each Tasks",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent(ref="#/components/schemas/ProjectResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function getEachTask(Request $request, $id)
    {
        try {
            $task = Task::where('id', $id)->paginate(10)->get();
            return response()->json($task, 200);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
