<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 1/4/2020
 * Time: 2:22 μμ
 */

namespace App\Services;

use App\Traits\ConsumesExternalService;
use App\Utility\CacheConstants;
use App\Utility\CacheHelper;

/**
 * Class ProjectService
 * @package App\Services
 */
class ProjectService extends BaseService
{
    use ConsumesExternalService;


    /**
     * ProjectService constructor.
     * @param CacheHelper $cacheHelper
     */
    public function __construct(CacheHelper $cacheHelper)
    {
        $this->baseUri = config('services.projects.base_uri');
        $this->secret = config('services.projects.secret');

        parent::__construct($cacheHelper);

    }

    /**
     * Return all projects
     * @param $data
     * @return string
     */
    public function obtainProjects($data = [])
    {
        //$this->cacheHelper->deleteCollection($this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS);

        // If the request has filters attached we need to get them from API and dont cache it
        if (!empty($data)) {
            $projects = $this->performRequest('GET', '/projects', $data);
            return $projects;
        }

        // if item is cached return from the cache memory
        if (!empty($this->cacheHelper->cacheEntityExists($this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS))) {
            $projects = $this->denormalizePayload($this->cacheHelper->getCachedCollection($this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS));
        } else { // else get them from API and cache them
            $projects = $this->performRequest('GET', '/projects', $data);
            if (!empty($projects)) {

                $this->cacheHelper->cacheCollectionHelper($this->normalizePayload($projects), 'id', $this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS);
            }
        }
        return $projects;
    }

    /**
     * Create a new project
     * @param $data
     * @return string
     */
    public function createProject($data)
    {

        $projectData = $this->performRequest('POST', '/projects', $data);
        $this->cacheHelper->cacheCollectionHelper($this->normalizePayload($projectData), 'id', $this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS, true);
        return $projectData;
    }

    /**
     * Return one project
     * @param $project
     * @return string
     */
    public function obtainProject($project)
    {
        $cachedProject = $this->cacheHelper->getCachedCollectionEntity($this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS, $project);

        if (!empty($cachedProject)) {
            return $this->denormalizePayload($cachedProject);
        }
        // Here the right thing to do would be to request for ALL projects and cache the whole collection
        // But because I do that at obtainProjects method I assume that someone will call it and they will be cached from there
        return $this->performRequest('GET', "projects/{$project}");
    }

    /**
     * Update a project
     * @param $data
     * @param $project
     * @return string
     */
    public function editProject($data, $project)
    {
        $projectData = $this->performRequest('PUT', "projects/{$project}", $data);
        $cachedProject = $this->cacheHelper->getCachedCollectionEntity($this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS, $project);

        // Update the Hash Cache for that single item
        if (!empty($cachedProject)) {
            $this->cacheHelper->cacheCollectionHelper($this->normalizePayload($projectData), 'id', $this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS, true);
        }
        return $projectData;

    }

    /**
     * Delete project
     * @param $project
     * @return string
     */
    public function deleteProject($project)
    {
        $deletedProject = $this->performRequest('DELETE', "projects/{$project}");
        $cachedProject = $this->cacheHelper->getCachedCollectionEntity($this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS, $project);

        // Delete the Hash Cache for that single item
        if (!empty($cachedProject)) {
            $this->cacheHelper->deleteCollectionItem($this->prefix . CacheConstants::CACHED_ENTITY_PROJECTS,$project);
        }
        return $deletedProject;
    }
}
