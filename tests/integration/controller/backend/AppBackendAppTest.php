<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\App;

class AppBackendAppTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'apps',
        'users',
        'languages',
        'clients',
        'permissions',
        'roles',
        'user_has_permissions',
        'user_has_roles',
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

        $this->readPermission   = create_test_permission_with_name('apps.read');
        $this->writePermission  = create_test_permission_with_name('apps.write');
        $this->deletePermission = create_test_permission_with_name('apps.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_app()
    {
        $this->visit('/backend/apps')
            ->see(trans('backend/apps.apps'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_app()
    {
        $record = create_test_app();
        $this->visit('/backend/apps')
            ->see(trans('backend/apps.apps'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_app_and_use_the_back_button()
    {
        $record = create_test_app();
        $this->visit('/backend/apps')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/apps/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/apps');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_app_and_change_values()
    {
        $record = create_test_app();

        $this->visit('/backend/apps/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated App', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/apps.save'));
            })
            ->see(trans('backend/apps.updated'))
            ->see('Updated App')
            ->seePageIs('/backend/apps');

        $record = App::find($record->id);
        $this->assertEquals('Updated App', $record->name);
    }

    /** @test */
    public function can_click_the_app_create_button()
    {
        $this->visit('/backend/apps')
            ->click(trans('backend/apps.new'))
            ->seePageIs('/backend/apps/create');
    }

    /** @test */
    public function can_create_a_new_app()
    {
        $this->visit('/backend/apps/create')
            ->see(trans('backend/apps.new'))
            ->type('Create App Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/apps.save'));
            })
            ->see(trans('backend/apps.created'))
            ->see('Create App Name')
            ->seePageIs('/backend/apps');
    }

    /** @test */
    public function cannot_create_a_new_app_with_empty_fields()
    {
        $this->visit('/backend/apps/create')
            ->see(trans('backend/apps.new'))
            ->within('.box-footer', function(){
                $this->press(trans('backend/apps.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/apps/create');
    }

    /** @test */
    public function can_modify_a_app()
    {
        $record = create_test_app();
        $this->visit('/backend/apps/'.$record->id.'/edit')
            ->see(trans('backend/apps.edit'))
            ->type('Modified App Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/apps.save'));
            })
            ->see(trans('backend/apps.updated'))
            ->see('Modified App Name')
            ->seePageIs('/backend/apps');
    }

    /** @test */
    public function can_delete_a_app()
    {
        create_test_app();

        $this->assertCount(1, App::all());

        $this->visit('/backend/apps')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/apps')
            ->see(trans('backend/apps.deleted'));

        $this->assertCount(0, App::all());
    }

    /** @test */
    public function can_paginate_app_results()
    {
        $records = create_test_app(100);
        $this->visit('/backend/apps')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/apps?page=3');
    }

    /** @test */
    public function can_search_app_results()
    {
        $records = create_test_app(10);
        $this->visit('/backend/apps')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
