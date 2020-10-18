<?php

use Illuminate\Database\Seeder;
use DB;

class PaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	 DB::table('roles')->insert(
            array(
                array('name'=>'Partenaire', 'slug'=>str_randomize(10)),
                array('name'=>'Client', 'slug'=>str_randomize(10)),
                array('name'=>'Controleur', 'slug'=>str_randomize(10)),
                array('name'=>'Agent', 'slug'=>str_randomize(10))
            ));



              [
              	'nom' => 'Tchad',
                'nicename' => 'Republique du Tchad',
                'iso' => 'TD',
                'iso3' => 'TCD',
                'numcode' => 235,
                'phonecode' => 235,
                'flag' => 'chad',
                'slug' => 'republique-du-chad',
                'capitale' => 
            ]
    }
}
