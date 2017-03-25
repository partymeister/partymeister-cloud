<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Website;

class AppBackendWebsiteTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'websites',
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

        $this->readPermission   = create_test_permission_with_name('websites.read');
        $this->writePermission  = create_test_permission_with_name('websites.write');
        $this->deletePermission = create_test_permission_with_name('websites.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_website()
    {
        $this->visit('/backend/websites')
            ->see(trans('backend/websites.websites'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_website()
    {
        $record = create_test_website();
        $this->visit('/backend/websites')
            ->see(trans('backend/websites.websites'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_website_and_use_the_back_button()
    {
        $record = create_test_website();
        $this->visit('/backend/websites')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/websites/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/websites');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_website_and_change_values()
    {
        $record = create_test_website();

        $this->visit('/backend/websites/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Website', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/websites.save'));
            })
            ->see(trans('backend/websites.updated'))
            ->see('Updated Website')
            ->seePageIs('/backend/websites');

        $record = Website::find($record->id);
        $this->assertEquals('Updated Website', $record->name);
    }

    /** @test */
    public function can_click_the_website_create_button()
    {
        $this->visit('/backend/websites')
            ->click(trans('backend/websites.new'))
            ->seePageIs('/backend/websites/create');
    }

    /** @test */
    public function can_create_a_new_website()
    {
        $this->visit('/backend/websites/create')
            ->see(trans('backend/websites.new'))
            ->type('Create Website Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/websites.save'));
            })
            ->see(trans('backend/websites.created'))
            ->see('Create Website Name')
            ->seePageIs('/backend/websites');
    }

    /** @test */
    public function cannot_create_a_new_website_with_empty_fields()
    {
        $this->visit('/backend/websites/create')
            ->see(trans('backend/websites.new'))
            ->within('.box-footer', function(){
                $this->press(trans('backend/websites.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/websites/create');
    }

    /** @test */
    public function can_modify_a_website()
    {
        $record = create_test_website();
        $this->visit('/backend/websites/'.$record->id.'/edit')
            ->see(trans('backend/websites.edit'))
            ->type('Modified Website Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('backend/websites.save'));
            })
            ->see(trans('backend/websites.updated'))
            ->see('Modified Website Name')
            ->seePageIs('/backend/websites');
    }

    /** @test */
    public function can_delete_a_website()
    {
        create_test_website();

        $this->assertCount(1, Website::all());

        $this->visit('/backend/websites')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/websites')
            ->see(trans('backend/websites.deleted'));

        $this->assertCount(0, Website::all());
    }

    /** @test */
    public function can_paginate_website_results()
    {
        $records = create_test_website(100);
        $this->visit('/backend/websites')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/websites?page=3');
    }

    /** @test */
    public function can_search_website_results()
    {
        $records = create_test_website(10);
        $this->visit('/backend/websites')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}
