<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ;
        User::create([
            'name'=>'e-boudhina',
            'email'=>'e-boudhina@live.fr',
            'password'=>Hash::make('07219567'),
            'created_at'=>now()
        ]);
    }
}
