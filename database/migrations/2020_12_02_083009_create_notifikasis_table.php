<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            // type untuk menentukan apakah jenis notifikasi dalam bentuk postingan text, photo, atau video, atau add pertemanan
            $table->integer("type");
            $table->unsignedBigInteger("postingan_id")->nullable();
            $table->unsignedBigInteger("kepada");
            $table->unsignedBigInteger("dari");
            $table->integer("dibaca")->default(0);
            $table->integer("dibuat_pada");

            $table->foreign("kepada")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("dari")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("postingan_id")->references("id")->on("postingans")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifikasis');
    }
}
