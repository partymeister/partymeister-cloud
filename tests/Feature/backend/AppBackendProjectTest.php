<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Project;

class AppBackendProjectTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'projects',
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

        $this->readPermission   = create_test_permission_with_name('projects.read');
        $this->writePermission  = create_test_permission_with_name('projects.write');
        $this->deletePermission = create_test_permission_with_name('projects.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_project()
    {
        $this->browse(function ($browser) {
            $browser->visit('/backend/projects')
                ->see(trans('backend/projects.projects'))
                ->see(trans('motor-backend::backend/global.no_records'));
        });
    }

    /** @test */
    public function can_see_grid_with_one_project()
    {
        $record = create_test_project();
        $this->visit('/backend/projects')
            ->see(trans('backend/projects.projects'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_project_and_use_the_back_button()
    {
        $record = create_test_project();
        $this->visit('/backend/projects')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/projects/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/projects');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_project_and_change_values()
    {
        $record = create_test_project();

        $this->visit('/backend/projects/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Project', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/projects.save'));
            })
            ->see(trans('backend/projects.updated'))
            ->see('Updated Project')
            ->seePageIs('/backend/projects');

        $record = Project::find($record->id);
        $this->assertEquals('Updated Project', $record->name);
    }

    /** @test */
    public function can_click_the_project_create_button()
    {
        $this->visit('/backend/projects')
            ->click(trans('backend/projects.new'))
            ->seePageIs('/backend/projects/create');
    }

    /** @test */
    public function can_create_a_new_project()
    {
        $this->visit('/backend/projects/create')
            ->see(trans('backend/projects.new'))
            ->type('Create Project Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/projects.save'));
            })
            ->see(trans('backend/projects.created'))
            ->see('Create Project Name')
            ->seePageIs('/backend/projects');
    }

    /** @test */
    public function cannot_create_a_new_project_with_empty_fields()
    {
        $this->visit('/backend/projects/create')
            ->see(trans('backend/projects.new'))
            ->within('.box-footer', function(){
                $this->press(trans('backend/projects.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/projects/create');
    }

    /** @test */
    public function can_modify_a_project()
    {
        $record = create_test_project();
        $this->visit('/backend/projects/'.$record->id.'/edit')
            ->see(trans('backend/projects.edit'))
            ->type('Modified Project Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/projects.save'));
            })
            ->see(trans('backend/projects.updated'))
            ->see('Modified Project Name')
            ->seePageIs('/backend/projects');
    }

    /** @test */
    public function can_delete_a_project()
    {
        create_test_project();

        $this->assertCount(1, Project::all());

        $this->visit('/backend/projects')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/projects')
            ->see(trans('backend/projects.deleted'));

        $this->assertCount(0, Project::all());
    }

    /** @test */
    public function can_paginate_project_results()
    {
        $records = create_test_project(100);
        $this->visit('/backend/projects')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/projects?page=3');
    }

    /** @test */
    public function can_search_project_results()
    {
        $records = create_test_project(10);
        $this->visit('/backend/projects')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
