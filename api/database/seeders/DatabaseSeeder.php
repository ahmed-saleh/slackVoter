<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Event;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Item::factory(10)->create();
        Event::factory(1)->create();
    }
}
