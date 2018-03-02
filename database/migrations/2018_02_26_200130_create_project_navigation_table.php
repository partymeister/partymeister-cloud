<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateProjectNavigationTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_navigations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();
            $table->string('name');
            $table->string('icon');
            $table->string('url');
            $table->string('page');
            $table->string('function');
            $table->boolean('is_protected');
            $table->boolean('is_default');
            $table->boolean('is_hidden_when_logged_in');
            $table->boolean('is_visible_for_at_home');

            $table->string('scope')->index();
            NestedSet::columns($table);

            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_navigations');
    }
}
