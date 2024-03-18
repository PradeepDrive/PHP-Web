<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Page;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $user = User::create([
           "email" => "santhosh@gamil.com",
           "username" => "admin11",
           "first_name" => "first",
           "last_name" => "last",
           "password" => Hash::make("santhosh11"),
           'email_verified_at' => now(),
            "landing_page" => 1,
       ]);
       $pages = Page::pluck('id')->toArray();
       $user->pagesAccess()->sync($pages);

        // for ($i=0; $i < 50; $i++) {
        //     $email = str_shuffle($email);
        //    User::create([
        //     'email' => $email. mt_rand(1,9999) ."@gmail.com",
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        //    ]);
        // }
        // $this->call(UsersTableSeeder::class);
    }
}
