<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('event_id')->references('id')->on('events');
            $table->foreignId('item_id')->references('id')->on('items');
            $table->tinyInteger('vote_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_item');
    }
}
