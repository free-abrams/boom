<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('title')->nullable()->after('guard_name');
            $table->integer('parent_id')->index()->default(0)->after('id');
            $table->integer('level')->nullable()->default(0)->after('title');
            $table->string('path')->nullable()->after('level');
            $table->string('route')->nullable()->after('path');
            $table->string('sort')->nullable()->after('route');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
