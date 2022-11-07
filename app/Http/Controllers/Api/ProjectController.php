<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/project-create",
     * tags={"Projects"},
     * summary="create Project",
     * description="Admin create a project",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               required={"Project_name"},
     *               @OA\Property(property="Project_name", type="required|string"),
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
    public function createProject(Request $request)
    {
        $addProject = new Project;
        $addProject->project_name = $request->project_name;
        $addProject->save();

        $response = [
            'message' => 'Project Created'
        ];

        return response($response, 201);
    }

  /**
     * @OA\Get(
     *      path= "api/project-create",
     *      tags={"Projects"},
     *      summary="Get all Projects",
     *      description="Get all Projects",
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
    public function getAllProject(Request $request)
    {
        $project = Project::all()->paginate(10);
        return response()->json($project, 200);
    }



     /**
     * @OA\Get(
     *      path= "api/user-projects/{$project_id}",
     *      tags={"Projects"},
     *      summary="Get each Projects",
     *      description="Get each Projects",
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
    public function getEachProject(Request $request, $id)
    {
        try {
            $project = Project::where('id', $id)->paginate(10)->get();
            return response()->json($project, 200);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
