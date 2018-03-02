<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ProjectNavigation;

class AppBackendProjectNavigationTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'project_navigations',
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

        $this->readPermission   = create_test_permission_with_name('project_navigations.read');
        $this->writePermission  = create_test_permission_with_name('project_navigations.write');
        $this->deletePermission = create_test_permission_with_name('project_navigations.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_project_navigation()
    {
        $this->visit('/backend/project_navigations')
            ->see(trans('backend/project_navigations.project_navigations'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_project_navigation()
    {
        $record = create_test_project_navigation();
        $this->visit('/backend/project_navigations')
            ->see(trans('backend/project_navigations.project_navigations'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_project_navigation_and_use_the_back_button()
    {
        $record = create_test_project_navigation();
        $this->visit('/backend/project_navigations')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/project_navigations/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/project_navigations');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_project_navigation_and_change_values()
    {
        $record = create_test_project_navigation();

        $this->visit('/backend/project_navigations/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Project navigation', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/project_navigations.save'));
            })
            ->see(trans('backend/project_navigations.updated'))
            ->see('Updated Project navigation')
            ->seePageIs('/backend/project_navigations');

        $record = ProjectNavigation::find($record->id);
        $this->assertEquals('Updated Project navigation', $record->name);
    }

    /** @test */
    public function can_click_the_project_navigation_create_button()
    {
        $this->visit('/backend/project_navigations')
            ->click(trans('backend/project_navigations.new'))
            ->seePageIs('/backend/project_navigations/create');
    }

    /** @test */
    public function can_create_a_new_project_navigation()
    {
        $this->visit('/backend/project_navigations/create')
            ->see(trans('backend/project_navigations.new'))
            ->type('Create Project navigation Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/project_navigations.save'));
            })
            ->see(trans('backend/project_navigations.created'))
            ->see('Create Project navigation Name')
            ->seePageIs('/backend/project_navigations');
    }

    /** @test */
    public function cannot_create_a_new_project_navigation_with_empty_fields()
    {
        $this->visit('/backend/project_navigations/create')
            ->see(trans('backend/project_navigations.new'))
            ->within('.box-footer', function(){
                $this->press(trans('backend/project_navigations.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/project_navigations/create');
    }

    /** @test */
    public function can_modify_a_project_navigation()
    {
        $record = create_test_project_navigation();
        $this->visit('/backend/project_navigations/'.$record->id.'/edit')
            ->see(trans('backend/project_navigations.edit'))
            ->type('Modified Project navigation Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/project_navigations.save'));
            })
            ->see(trans('backend/project_navigations.updated'))
            ->see('Modified Project navigation Name')
            ->seePageIs('/backend/project_navigations');
    }

    /** @test */
    public function can_delete_a_project_navigation()
    {
        create_test_project_navigation();

        $this->assertCount(1, ProjectNavigation::all());

        $this->visit('/backend/project_navigations')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/project_navigations')
            ->see(trans('backend/project_navigations.deleted'));

        $this->assertCount(0, ProjectNavigation::all());
    }

    /** @test */
    public function can_paginate_project_navigation_results()
    {
        $records = create_test_project_navigation(100);
        $this->visit('/backend/project_navigations')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/project_navigations?page=3');
    }

    /** @test */
    public function can_search_project_navigation_results()
    {
        $records = create_test_project_navigation(10);
        $this->visit('/backend/project_navigations')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
