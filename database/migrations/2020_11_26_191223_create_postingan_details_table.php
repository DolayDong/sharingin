<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostinganDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postingan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("postingan_id");
            $table->string("nama_file")->default(NULL)->nullable();
            $table->integer("ukuran_file")->default(0)->nullable();
            $table->text("caption")->nullable();

            $table->foreign('postingan_id')->references('id')->on('postingans')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postingan_details');
    }
}
