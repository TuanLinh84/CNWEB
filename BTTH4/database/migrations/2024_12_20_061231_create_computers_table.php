<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->increments('id'); // Mã máy tính
            $table->string('computer_name', 50); // Tên máy tính (vd: "Lab1-PC05")
            $table->string('model', 100); // Tên phiên bản (vd: "Dell Optiplex 7090")
            $table->string('operating_system', 50); // Hệ điều hành (vd: "Windows 10 Pro")
            $table->string('processor', 50); // Bộ vi xử lý (vd: "Intel Core i5-11400")
            $table->integer('memory'); // Bộ nhớ RAM (GB)
            $table->boolean('available'); // Trạng thái hoạt động (true/false)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('computers');
    }
}