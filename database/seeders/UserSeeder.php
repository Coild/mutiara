<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'nama' => 'admin'
        ], [
            'nama' => 'admin',
            'level' => 'admin',
            'password' => bcrypt('admin123')
        ]);

        User::updateOrCreate([
            'nama' => 'kasir'
        ], [
            'nama' => 'kasir',
            'level' => 'kasir',
            'password' => bcrypt('kasir123')
        ]);
    }
}
