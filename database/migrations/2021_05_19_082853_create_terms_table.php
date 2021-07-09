<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('statamic-eloquent-driver.terms.enabled', true)) {
            Schema::create('taxonomy_terms', function (Blueprint $table) {
                $table->id();
                $table->string('site');
                $table->string('slug');
                $table->string('uri')->nullable();
                $table->string('taxonomy');
                $table->json('data');
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
        if (config('statamic-eloquent-driver.terms.enabled', true)) {
            Schema::dropIfExists('taxonomy_terms');
        }
    }
}
