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
        Schema::create('tik', function (Blueprint $table) {
            $table->id();  // Kolom id otomatis sebagai primary key
            $table->string('title');  // Kolom title dengan tipe data string
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('tik');
    }
};
