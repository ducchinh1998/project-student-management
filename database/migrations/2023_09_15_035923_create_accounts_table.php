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
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('username');
            $table->string('avatar');
            $table->string('password');
            $table->string('code');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('birthday');
            
            $table->string('field');
            $table->string('description')->nullable();

            $table->tinyInteger('status')->default(1);

            // Sinh viên, Giảng viên, Trợ lý phòng đào tạo
            $table->enum('position', ['Student', 'Lecturer', 'Administrators']);

            $table->string('remember_token')->nullable();

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
        Schema::dropIfExists('accounts');
    }
};
