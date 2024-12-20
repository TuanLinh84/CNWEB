<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id'); // Mã vấn đề báo cáo
            $table->unsignedInteger('computer_id'); // Khóa ngoại tới computers.id
            $table->string('reported_by', 50)->nullable(); // Người báo cáo sự cố (tùy chọn)
            $table->dateTime('reported_date'); // Thời gian báo cáo
            $table->text('description'); // Mô tả chi tiết vấn đề
            $table->enum('urgency', ['Low', 'Medium', 'High']); // Mức độ sự cố
            $table->enum('status', ['Open', 'In Progress', 'Resolved']); // Trạng thái hiện tại
            $table->timestamps();

            $table->foreign('computer_id')
                  ->references('id')
                  ->on('computers')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('issues');
    }
}