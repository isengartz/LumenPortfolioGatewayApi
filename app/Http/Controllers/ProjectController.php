<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;


use App\Services\ProjectService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ApiResponser;

    public $projectService;


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
     * Return all projects
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        return $this->successResponse($this->projectService->obtainProjects());
    }

    /**
     * Create a new project
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
         return $this->successResponse($this->projectService->createProject($request->all(), Response::HTTP_CREATED));
    }

    /**
     * Get a project
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($project){
        return $this->successResponse($this->projectService->obtainProject($project));
    }

    /**
     * Update a project
     * @param Request $request
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$project){
        return $this->successResponse($this->projectService->editProject($request->all(),$project));
    }

    /**
     * Deletes a project
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($project){
        return $this->successResponse($this->projectService->deleteProject($project));
    }
}
