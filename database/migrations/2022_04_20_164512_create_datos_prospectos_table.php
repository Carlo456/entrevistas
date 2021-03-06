<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_prospectos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyText('seniority');
            $table->string('disponibility');
            $table->string('curriculum_filename');
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
        Schema::dropIfExists('datos_prospectos');
    }
};

?>
