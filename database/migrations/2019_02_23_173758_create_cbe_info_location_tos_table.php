<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbeInfoLocationTosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        if (!Schema::hasTable('cbe_info_location_tos')) 
        {
            Schema::create('cbe_info_location_tos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('location_to_name', 150);
                $table->unsignedInteger('created_by');
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('created_by')->references('id')->on('users');
                $table->foreign('updated_by')->references('id')->on('users')->default(NULL);
            });
        }
        Schema::enableForeignKeyConstraints();        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cbe_info_location_tos');
    }
}