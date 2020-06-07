<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 7/6/2020
 * Time: 3:01 πμ
 */

namespace App\Services;


use App\Traits\ConsumesExternalService;
use App\Utility\CacheConstants;
use App\Utility\CacheHelper;

class BaseService
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
     * @var
     */
    protected $cacheHelper;
    /**
     * The only reason we use prefix is, because if we have more than 1 project tha uses Redis in the same server
     * There is a change that we have same keys and then It will return random shit things.
     * Happened once , so better safe than sorry xD
     * @var
     */
    protected $prefix;

    /**
     * The variable name where the data is stored when receiving a payload from API
     * Only usable for normalize the payload
     * @var
     */
    private $dataIdentifier;

    /**
     * BaseService constructor.
     * @param CacheHelper $cacheHelper
     */
    public function __construct(CacheHelper $cacheHelper)
    {
        $this->cacheHelper = $cacheHelper;
        $this->dataIdentifier = CacheConstants::CACHED_PAYLOAD_DATA_IDENTIFIER;
        $this->prefix = env('REDIS_API_PREFIX');

    }

    /**
     * So what happens here is that when I made they ProjectService API didn't thought about Redis
     * And the data of projects are inside an array with "data" as a key .
     * In order to be able to use the hash get/set from Redis I need to only store the actual data
     * So I extract all the data from ["data"] so I can properly store them in Redis
     * @param $data
     * @return array|mixed
     */
    protected function normalizePayload($data)
    {
        $normalized = json_decode($data, true);

        if ($normalized) {
            return $this->dataIdentifier !== '' ? $normalized[$this->dataIdentifier] : $normalized;
        }
        return [];
    }

    /**
     * The opposite thing from above. I return the data from redis inside a ["data"] array
     * @param $data
     * @return array
     */
    protected function denormalizePayload($data)
    {

        $denormalized = [];
        foreach ($data as $key => $value) {
            $denormalized[] = json_decode($value, true);
        }
        return $this->dataIdentifier !== '' ? [$this->dataIdentifier => $denormalized] : $denormalized;

    }
}
