<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ProjectNavigationTree;

class AppBackendProjectNavigationTreeTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'project_navigation_trees',
        'users',
        'languages',
        'clients',
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
        'role_has_permissions',
        'media'
    ];


    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../../../../database/factories');

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user   = create_test_superadmin();

        $this->readPermission   = create_test_permission_with_name('project_navigation_trees.read');
        $this->writePermission  = create_test_permission_with_name('project_navigation_trees.write');
        $this->deletePermission = create_test_permission_with_name('project_navigation_trees.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_project_navigation_tree()
    {
        $this->visit('/backend/project_navigation_trees')
            ->see(trans('backend/project_navigation_trees.project_navigation_trees'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_project_navigation_tree()
    {
        $record = create_test_project_navigation_tree();
        $this->visit('/backend/project_navigation_trees')
            ->see(trans('backend/project_navigation_trees.project_navigation_trees'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_project_navigation_tree_and_use_the_back_button()
    {
        $record = create_test_project_navigation_tree();
        $this->visit('/backend/project_navigation_trees')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/project_navigation_trees/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/project_navigation_trees');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_project_navigation_tree_and_change_values()
    {
        $record = create_test_project_navigation_tree();

        $this->visit('/backend/project_navigation_trees/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Project navigation tree', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/project_navigation_trees.save'));
            })
            ->see(trans('backend/project_navigation_trees.updated'))
            ->see('Updated Project navigation tree')
            ->seePageIs('/backend/project_navigation_trees');

        $record = ProjectNavigationTree::find($record->id);
        $this->assertEquals('Updated Project navigation tree', $record->name);
    }

    /** @test */
    public function can_click_the_project_navigation_tree_create_button()
    {
        $this->visit('/backend/project_navigation_trees')
            ->click(trans('backend/project_navigation_trees.new'))
            ->seePageIs('/backend/project_navigation_trees/create');
    }

    /** @test */
    public function can_create_a_new_project_navigation_tree()
    {
        $this->visit('/backend/project_navigation_trees/create')
            ->see(trans('backend/project_navigation_trees.new'))
            ->type('Create Project navigation tree Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/project_navigation_trees.save'));
            })
            ->see(trans('backend/project_navigation_trees.created'))
            ->see('Create Project navigation tree Name')
            ->seePageIs('/backend/project_navigation_trees');
    }

    /** @test */
    public function cannot_create_a_new_project_navigation_tree_with_empty_fields()
    {
        $this->visit('/backend/project_navigation_trees/create')
            ->see(trans('backend/project_navigation_trees.new'))
            ->within('.box-footer', function(){
                $this->press(trans('backend/project_navigation_trees.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/project_navigation_trees/create');
    }

    /** @test */
    public function can_modify_a_project_navigation_tree()
    {
        $record = create_test_project_navigation_tree();
        $this->visit('/backend/project_navigation_trees/'.$record->id.'/edit')
            ->see(trans('backend/project_navigation_trees.edit'))
            ->type('Modified Project navigation tree Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/project_navigation_trees.save'));
            })
            ->see(trans('backend/project_navigation_trees.updated'))
            ->see('Modified Project navigation tree Name')
            ->seePageIs('/backend/project_navigation_trees');
    }

    /** @test */
    public function can_delete_a_project_navigation_tree()
    {
        create_test_project_navigation_tree();

        $this->assertCount(1, ProjectNavigationTree::all());

        $this->visit('/backend/project_navigation_trees')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/project_navigation_trees')
            ->see(trans('backend/project_navigation_trees.deleted'));

        $this->assertCount(0, ProjectNavigationTree::all());
    }

    /** @test */
    public function can_paginate_project_navigation_tree_results()
    {
        $records = create_test_project_navigation_tree(100);
        $this->visit('/backend/project_navigation_trees')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/project_navigation_trees?page=3');
    }

    /** @test */
    public function can_search_project_navigation_tree_results()
    {
        $records = create_test_project_navigation_tree(10);
        $this->visit('/backend/project_navigation_trees')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
