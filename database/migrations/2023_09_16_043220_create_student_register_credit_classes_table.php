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
        // Đăng kí học
        Schema::create('student_register_credit_classes', function (Blueprint $table) {
            // Sinh viên 
            $table->integer('student_id')->unsigned();
            // Lớp tín chỉ
            $table->integer('credit_class_id')->unsigned();
            // Thời điểm đăng kí
            $table->timestamp('registered_at');

            $table->float('revise_point')->default(0);
            $table->float('middle_test_point')->default(0);
            $table->float('practice_point')->default(0);
            $table->float('attendance_point')->default(0);
            $table->float('finish_test_point')->default(0);
            $table->float('avg_point')->default(0);

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('credit_class_id')->references('id')->on('credit_classes');

            $table->primary(['student_id', 'credit_class_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_register_credit_classes');
    }
};
