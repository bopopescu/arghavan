<?php

use Illuminate\Database\Seeder;

class AmoebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $amoeba_one =  \App\Amoeba::create([
            'ip' => '192.168.1.10',
            'name' => 'سوئیچ شماره یک',
            'enabled' => 1,
        ]);

        \App\Amoeba::create([
            'ip' => '192.168.1.11',
            'name' => 'سوئیچ شماره  دو',
            'enabled' => 1,
        ]);

        $amoeba_one->gatedevices()->attach([ 2, 3 ]);
    }
}
