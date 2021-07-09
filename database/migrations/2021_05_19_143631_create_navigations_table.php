<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('statamic-eloquent-driver.navigations.enabled', true)) {
            Schema::create('navigations', function (Blueprint $table) {
                $table->id();
                $table->string('handle');
                $table->string('title');
                $table->json('collections')->nullable();
                $table->integer('maxDepth')->nullable();
                $table->boolean('expectsRoot')->default(false);
                $table->string('initialPath')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('statamic-eloquent-driver.navigations.enabled', true)) {
            Schema::dropIfExists('navigations');
        }
    }
}
