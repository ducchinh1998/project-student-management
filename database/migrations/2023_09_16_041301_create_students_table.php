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
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            // Điểm trung bình môn (Cumulative GPA)
            $table->float('cpa')->default(0);
            // Điểm trung bình rèn luyện (Training point average)
            $table->float('tpa')->default(0);
            // Mức độ cảnh cáo
            $table->integer('warning_level')->default(0);

            // Khoa
            $table->integer('faculty_id')->unsigned();
            // Lớp chuyên ngành
            $table->integer('class_id')->unsigned();
            // Tài khoản
            $table->integer('account_id')->unsigned();
            $table->timestamps();

            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
