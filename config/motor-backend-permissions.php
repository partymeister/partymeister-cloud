<?php

/**
 * motor-backend permission configuration
 * Check the module permission file at vendor/dfox288/motor-backend/resources/config/motor-backend-permissions.php for
 * more information on how to use this
 */

return [
    'projects'                 => [
        'name'   => 'backend/projects.projects',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'apps'                     => [
        'name'   => 'backend/apps.apps',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'websites'                 => [
        'name'   => 'backend/websites.websites',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'project_navigations'      => [
        'name'   => 'backend/project_navigations.project_navigations',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'project_navigation_trees' => [
        'name'   => 'backend/project_navigation_trees.project_navigation_trees',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
];