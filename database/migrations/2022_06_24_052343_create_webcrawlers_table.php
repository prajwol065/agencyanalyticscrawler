<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebcrawlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webcrawlers', function (Blueprint $table) {
            $table->id();
            $table->string('page_url');
            $table->integer('word_count')->unsigned()->nullable();
            $table->integer('average_title_length')->unsigned()->nullable();
            $table->float('time_taken')->unsigned()->nullable();
            $table->string('http_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webcrawlers');
    }
}
