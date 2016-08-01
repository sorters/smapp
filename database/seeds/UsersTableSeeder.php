<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@sorters.io',
            'api_token' => 'IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY',
            'password' => '$2y$10$zi7VUnFmoFRINXQdNLEgzuEr6hiQuVb6TcyU80POAgNV1W24jTEcK',
            'created_at' => null,
            'updated_at' => null,
        ]);
    }
}
