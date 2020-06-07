<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 7/6/2020
 * Time: 4:48 μμ
 */

namespace App\Http\Controllers;


use App\Utility\CacheConstants;
use App\Utility\CacheHelper;

/**
 * Class HelperController
 * @package App\Http\Controllers
 */
class HelperController extends Controller
{
    /**
     * @var CacheHelper
     */
    private $cacheHelper;
    /**
     * @var mixed
     */
    private $prefix;

    /**
     * HelperController constructor.
     * @param CacheHelper $cacheHelper
     */
    public function __construct(CacheHelper $cacheHelper)
    {
        $this->cacheHelper = $cacheHelper;
        $this->prefix = env('REDIS_API_PREFIX');
    }

    /**
     * Invalidate All Cached Entities
     */
    public function invalidateAll()
    {

        foreach (CacheConstants::CACHED_ENTITIES as $entity) {
            $this->cacheHelper->deleteCollection($this->prefix . $entity);
        }
        echo 'done';
    }
}
