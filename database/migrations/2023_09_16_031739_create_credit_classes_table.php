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
        Schema::create('credit_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            // Mã lớp tín chỉ
            $table->string('code')->unique();

            // Giảng viên phụ trách
            $table->integer('lecturer_id')->unsigned();
            // Môn
            $table->integer('subject_id')->unsigned();
            // Khoa
            $table->integer('faculty_id')->unsigned();
            // Kì học 
            $table->integer('school_year_id')->unsigned();

            // Trọng số Điểm bài tập
            $table->float('revise_weight');
            // Trọng số Điểm kiểm tra
            $table->float('middle_test_weight');
            // Trọng số Điểm thực hành
            $table->float('practice_weight');
            // Trọng số Điểm chuyên cần
            $table->float('attendance_weight');
            // Trọng số Điểm thi
            $table->float('finish_test_weight');

            // Thời gian vào học
            $table->string('start_time');
            $table->string('end_time');

            $table->timestamps();
            
            $table->foreign('lecturer_id')->references('id')->on('accounts');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->foreign('school_year_id')->references('id')->on('school_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_classes');
    }
};
