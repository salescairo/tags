<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'user@exemple.com')->first();
        if (empty($user)) {
            $user = new User();
            $user->name = "User";
            $user->email = "user@exemple.com";
            $user->type = "master";
            $user->password = "12345678";
            $user->active = true;
            $user->save();
        }else{
            $user->password = "12345678";
            $user->active = true;
            $user->save();
        }
    }
}
