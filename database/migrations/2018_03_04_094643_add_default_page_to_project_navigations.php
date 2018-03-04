<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultPageToProjectNavigations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_navigations', function (Blueprint $table) {
            $table->boolean('is_default')->after('is_protected');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_navigations', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
}
