<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('statamic-eloquent-driver.taxonomies.enabled', true)) {
            Schema::create('taxonomies', function (Blueprint $table) {
                $table->increments('id');
                $table->string('handle');
                $table->string('title');
                $table->json('sites')->nullable();
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
        if (config('statamic-eloquent-driver.taxonomies.enabled', true)) {
            Schema::dropIfExists('taxonomies');
        }
    }
}
