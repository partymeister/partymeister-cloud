<?php

/**
 * motor-backend permission configuration
 * Check the module permission file at vendor/dfox288/motor-backend/resources/config/motor-backend-permissions.php for
 * more information on how to use this
 */

return [
    'projects' => [
        'name'   => 'backend/projects.projects',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'apps'     => [
        'name'   => 'backend/apps.apps',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'websites' => [
        'name'   => 'backend/websites.websites',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
];