<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'username' => 'phong_dao_tao_1',
            'avatar' => '157202302220191026000342g6LFGCz0rHPe8DIkAnwD4QBmgw1UFu4LQn1JAPoK.jpeg',
            'password' => bcrypt('123456'),
            'first_name' => 'Nguyen',
            'last_name' => 'Van A',
            'phone' => '033 6666 789',
            'email' => 'test@example.com',
            'address' => 'Hà Nội',
            'gender' => 'Male',
            'birthday' => '1990/08/08',
            'field' => 'Quản lý cấp cao',
            'description' => 'Quản lý cấp cao',
            'status' => 1,
            'position' => 'Administrators',
        ]);
    }
}
