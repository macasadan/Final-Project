<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Assuming you are using the User model

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@user.com', // set the user  email for admin
            'password' => bcrypt('password'), // Set the password you prefer
            'role' => 'admin', // role column to distinguish admins , Assign 'admin' role
        ]);
    }
}
