<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Method one is to use this with the predefined method in factories to create your fake data
        // but you can create them manually one by one using Classname::create([])
        Todo::factory(10)->create();

    }
}
