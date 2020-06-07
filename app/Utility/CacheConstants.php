<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 7/6/2020
 * Time: 2:37 πμ
 */

namespace App\Utility;


class CacheConstants
{
    const CACHED_PAYLOAD_DATA_IDENTIFIER='data';
    const CACHED_ENTITY_PROJECTS = 'projects';

    // Used for Invalidating ALL cache. If we had more than 1 ofc xD
    const CACHED_ENTITIES = [
        self::CACHED_ENTITY_PROJECTS
    ];
}
