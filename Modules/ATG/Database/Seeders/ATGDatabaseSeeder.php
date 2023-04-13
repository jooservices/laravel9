<?php

namespace Modules\ATG\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\ATG\Models\Item;

class ATGDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        /**
         * Quick seed for Items
         */

        Item::factory()->times(10)->create();
    }
}
