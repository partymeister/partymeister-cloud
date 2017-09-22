<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AppApiProjectTest extends TestCase
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
        $this->user = create_test_user();
        $this->readPermission   = create_test_permission_with_name('projects.read');
        $this->writePermission  = create_test_permission_with_name('projects.write');
        $this->deletePermission = create_test_permission_with_name('projects.delete');
    }


    /**
     * @test
     */
    public function returns_403_for_project_if_not_authenticated()
    {
        $this->json('GET', '/api/projects/1')->seeStatusCode(401)->seeJson([ 'error' => 'Unauthenticated.' ]);
    }


    /** @test */
    public function returns_404_for_non_existing_project_record()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/projects/1?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }


    /** @test */
    public function fails_if_trying_to_create_project_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/projects?api_token=' . $this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => [ "The name field is required." ]
        ]);
    }


    /** @test */
    public function fails_if_trying_to_create_project_without_permission()
    {
        $this->json('POST', '/api/projects?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => "Access denied."
        ]);
    }


    /** @test */
    public function can_create_a_new_project()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/projects?api_token=' . $this->user->api_token, [
            'name' => 'Test Project'
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Test Project'
        ]);
    }


    /** @test */
    public function can_show_a_single_project()
    {
        $this->user->givePermissionTo($this->readPermission);
        $record = create_test_project();
        $this->json('GET',
            '/api/projects/' . $record->id . '?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $record->name
        ]);
    }

    /** @test */
    public function fails_to_show_a_single_project_without_permission()
    {
        $record = create_test_project();
        $this->json('GET',
            '/api/projects/' . $record->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }

    /** @test */
    public function can_get_empty_result_when_trying_to_show_multiple_project()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/projects?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'total' => 0
        ]);
    }


    /** @test */
    public function can_show_multiple_project()
    {
        $this->user->givePermissionTo($this->readPermission);
        $records = create_test_project(10);
        $this->json('GET', '/api/projects?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $records[0]->name
        ]);
    }


    /** @test */
    public function can_search_for_a_project()
    {
        $this->user->givePermissionTo($this->readPermission);
        $records = create_test_project(10);
        $this->json('GET',
            '/api/projects?api_token=' . $this->user->api_token . '&search=' . $records[2]->name)->seeStatusCode(200)->seeJson([
            'name' => $records[2]->name
        ]);
    }


    /** @test */
    public function can_show_a_second_project_results_page()
    {
        $this->user->givePermissionTo($this->readPermission);
        create_test_project(50);
        $this->json('GET',
            '/api/projects?api_token=' . $this->user->api_token . '&page=2')->seeStatusCode(200)->seeJson([
            'current_page' => 2
        ]);
    }


    /** @test */
    public function fails_if_trying_to_update_nonexisting_project()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/projects/2?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found'
        ]);
    }


    /** @test */
    public function fails_if_trying_to_modify_a_project_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $record = create_test_project();
        $this->json('PATCH',
            '/api/projects/' . $record->id . '?api_token=' . $this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => [ 'The name field is required.' ]
        ]);
    }


    /** @test */
    public function fails_if_trying_to_modify_a_project_without_permission()
    {
        $record = create_test_project();
        $this->json('PATCH',
            '/api/projects/' . $record->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }

    /** @test */
    public function can_modify_a_project()
    {
        $this->user->givePermissionTo($this->writePermission);
        $record = create_test_project();
        $this->json('PATCH', '/api/projects/' . $record->id . '?api_token=' . $this->user->api_token, [
            'name' => 'Modified Project'
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Modified Project'
        ]);
    }


    /** @test */
    public function fails_if_trying_to_delete_a_non_existing_project()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $this->json('DELETE', '/api/projects/1?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found'
        ]);
    }


    /** @test */
    public function fails_to_delete_a_project_without_permission()
    {
        $record = create_test_project();
        $this->json('DELETE',
            '/api/projects/' . $record->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }

    /** @test */
    public function can_delete_a_project()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $record = create_test_project();
        $this->json('DELETE',
            '/api/projects/' . $record->id . '?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'success' => true
        ]);
    }
}
