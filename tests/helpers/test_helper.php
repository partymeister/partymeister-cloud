<?php

function create_test_project($count = 1)
{
    return factory(App\Models\Project::class, $count)->create();
}

function create_test_app($count = 1)
{
    return factory(App\Models\App::class, $count)->create();
}

function create_test_website($count = 1)
{
    return factory(App\Models\Website::class, $count)->create();
}

function create_test_project_navigation($count = 1)
{
    return factory(App\Models\ProjectNavigation::class, $count)->create();
}

function create_test_project_navigation_tree($count = 1)
{
    return factory(App\Models\ProjectNavigationTree::class, $count)->create();
}
