<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('statamic-eloquent-driver.global-sets.enabled', true)) {
            Schema::create('global_sets', function (Blueprint $table) {
                $table->id();
                $table->string('handle');
                $table->string('title');
                $table->json('localizations');
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
        if (config('statamic-eloquent-driver.global-sets.enabled', true)) {
            Schema::dropIfExists('global_sets');
        }
    }
}
