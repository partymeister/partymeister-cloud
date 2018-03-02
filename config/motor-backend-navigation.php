<?php

/**
 * motor-backend navigation configuration
 * Check the module navigation file at vendor/dfox288/motor-backend/resources/config/motor-backend-navigation.php for
 * more information on how to use this
 */

return [
    'items' => [
        100 => [
            'slug'        => 'pmcs',
            'name'        => 'backend/pmcs/global.partymeister',
            'icon'        => 'fa fa-cloud',
            'route'       => null,
            'roles'       => [ 'SuperAdmin' ],
            'permissions' => [],
            'items'       => [
                100 => [
                    'slug'        => 'projects',
                    'name'        => 'backend/projects.projects',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.projects.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [ 'projects.read' ],
                ],
                200 => [ // <-- !!! replace 209 with your own sort position !!!
                    'slug'        => 'apps',
                    'name'        => 'backend/apps.apps',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.apps.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [ 'apps.read' ],
                ],
                300 => [ // <-- !!! replace 883 with your own sort position !!!
                    'slug'        => 'project_navigation_trees',
                    'name'        => 'backend/project_navigation_trees.project_navigation_trees',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.project_navigation_trees.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [ 'project_navigation_trees.read' ],
                    'aliases'     => [ 'backend.project_navigations' ]
                ],
                400 => [ // <-- !!! replace 479 with your own sort position !!!
                    'slug'        => 'websites',
                    'name'        => 'backend/websites.websites',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.websites.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [ 'websites.read' ],
                ],
            ]
        ]
    ]
];