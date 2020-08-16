<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;


use App\Services\ProjectService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    use ApiResponser;

    private $projectService;


    /**
     * Create a new controller instance.
     *
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService=$projectService;

    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->projectService->obtainProjects($request->all()));
    }

    /**
     * Create new project
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
         return $this->successResponse($this->projectService->createProject($request->all(), Response::HTTP_CREATED));
    }

    /**
     * Get a project
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($project) : JsonResponse
    {
        return $this->successResponse($this->projectService->obtainProject($project));
    }

    /**
     * Update a project
     * @param Request $request
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$project) : JsonResponse
    {
        return $this->successResponse($this->projectService->editProject($request->all(),$project));
    }

    /**
     * Deletes a project
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($project) : JsonResponse
    {
        return $this->successResponse($this->projectService->deleteProject($project));
    }
}
