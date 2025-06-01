<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
   {
    Schema::create('games', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->decimal('price', 8, 2);
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
   }

    public function down()
   {   
    Schema::dropIfExists('games');
   }
};
