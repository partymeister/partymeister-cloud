<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfigOptionsToApps extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apps', function (Blueprint $table) {
            $table->string('onesignal_ios')->after('deinetickets_api_token');
            $table->string('onesignal_android')->after('deinetickets_api_token');
            $table->string('website_api_base_url')->after('deinetickets_api_token');
            $table->string('local_api_base_url')->after('deinetickets_api_token');
            $table->text('intro_text_1')->after('deinetickets_api_token');
            $table->text('intro_text_2')->after('deinetickets_api_token');
            $table->text('intro_text_3')->after('deinetickets_api_token');
            $table->text('intro_text_4')->after('deinetickets_api_token');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apps', function (Blueprint $table) {
            $table->dropColumn('onesignal_ios');
            $table->dropColumn('onesignal_android');
            $table->dropColumn('website_api_base_url');
            $table->dropColumn('local_api_base_url');
            $table->dropColumn('intro_text_1');
            $table->dropColumn('intro_text_2');
            $table->dropColumn('intro_text_3');
            $table->dropColumn('intro_text_1');
        });
    }
}
