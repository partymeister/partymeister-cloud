<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();
            $table->string('deinetickets_api_url');
            $table->string('deinetickets_api_token');
            $table->string('menu_type_url');
            $table->string('menu_structure_url');

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
        Schema::drop('apps');
    }
}
