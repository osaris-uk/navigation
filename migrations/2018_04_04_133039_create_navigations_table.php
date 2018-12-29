<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('order_by')->nullable();
            $table->string('target');
            $table->string('target_append')->nullable();
            $table->string('realm');
            $table->string('user_role')->nullable();
            $table->boolean('disabled')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navigations');
    }
}
