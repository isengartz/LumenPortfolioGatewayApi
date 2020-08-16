<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 1/4/2020
 * Time: 1:59 μμ
 */

return [
    'user' => [
        'base_uri' => env('USERS_SERVICE_BASE_URL')
    ],
    'projects' => [
        'base_uri' => env('PROJECTS_SERVICE_BASE_URL'),
        'secret' => env('PROJECTS_SERVICE_SECRET')
    ],
];
