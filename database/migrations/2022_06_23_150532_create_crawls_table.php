<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webcrawler_id')->constrained('webcrawlers')->onDelete('cascade');
            $table->string('extracted_url');
            $table->integer('is_internal')->unsigned();
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
        Schema::dropIfExists('crawls');
    }
}
