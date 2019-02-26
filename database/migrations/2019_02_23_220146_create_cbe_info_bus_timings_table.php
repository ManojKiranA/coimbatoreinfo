<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbeInfoBusTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        if (!Schema::hasTable('cbe_info_bus_timings'))
        {
            Schema::create('cbe_info_bus_timings', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('bus_id');
                $table->unsignedInteger('bus_type_id');
                $table->unsignedInteger('bus_route_id');
                $table->unsignedInteger('bus_point_from');
                $table->unsignedInteger('bus_point_to');
                $table->string('bus_time',15);
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
        Schema::dropIfExists('cbe_info_bus_timings');
    }
}
