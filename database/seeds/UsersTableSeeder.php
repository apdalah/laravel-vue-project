<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'apdalah@email.com',
            'password' => bcrypt('12345678')
        ]);

        $user->assignRole(['super_admin']);
    }
}
