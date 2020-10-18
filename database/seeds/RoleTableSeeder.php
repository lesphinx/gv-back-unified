<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
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

        DB::table('classes')->insert(
            array(
                array('libelle' => 'Ordinaire', 'description' => 'Ceci est la classe ordinaire', 'slug' => str_randomize(10))
            )
        );
		 
    }
}
