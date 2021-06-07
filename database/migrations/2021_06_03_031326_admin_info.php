<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_info', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('admin_id');
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('code')->nullable();
            $table->string('address')->nullable();
            $table->string('dob')->nullable();
            $table->string('telephone')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_info');
    }
}
