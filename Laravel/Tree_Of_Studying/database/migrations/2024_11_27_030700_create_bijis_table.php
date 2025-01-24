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
    Schema::create('bijis', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('ide');
        $table->string('cita_cita');
        $table->text('deskripsi');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bijis');
    }
};
