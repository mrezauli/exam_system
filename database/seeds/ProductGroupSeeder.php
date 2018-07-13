<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       


    	factory(Modules\Admin\ProductGroup::class, 1000)->create();






    }
}
