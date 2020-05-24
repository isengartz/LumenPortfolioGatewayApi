<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 1/4/2020
 * Time: 2:22 μμ
 */

namespace App\Services;

use App\Traits\ConsumesExternalService;

/**
 * Class ProjectService
 * @package App\Services
 */
class ProjectService
{
    use ConsumesExternalService;

    /**
     * @var mixed
     */
    public $baseUri;
    /**
     * @var mixed
     */
    public $secret;

    /**
     * ProjectService constructor.
     */
    public function __construct()
    {
        $this->baseUri=config('services.projects.base_uri');
        $this->secret=config('services.projects.secret');
    }

    /**
     * Return all projects
     * @param $data
     * @return string
     */
    public function obtainProjects($data=[]) {
        return $this->performRequest('GET','/projects',$data);
    }

    /**
     * Create a new project
     * @param $data
     * @return string
     */
    public function createProject($data){
        return $this->performRequest('POST','/projects',$data);
    }

    /**
     * Return one project
     * @param $project
     * @return string
     */
    public function obtainProject($project) {
        return $this->performRequest('GET',"projects/{$project}");
    }

    /**
     * Update a project
     * @param $data
     * @param $project
     * @return string
     */
    public function editProject($data,$project){
        return $this->performRequest('PUT',"projects/{$project}",$data);
    }

    /**
     * Delete project
     * @param $project
     * @return string
     */
    public function deleteProject($project){
        return $this->performRequest('DELETE',"projects/{$project}");
    }
}
