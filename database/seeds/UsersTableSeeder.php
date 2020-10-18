<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersGenerate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		  DB::table('users')->insert([
			[
					'email' 		=> 'admin@admin.com',
					'password' 		=> bcrypt('password'),
					'permissions' 	=> '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"user.index":true,"user.create":true,"user.store":true,"user.show":true,"user.edit":true,"user.update":true,"user.destroy":true,"user.permissions":true,"user.save":true,"user.activate":true,"user.deactivate":true,"role.index":true,"role.create":true,"role.store":true,"role.show":true,"role.edit":true,"role.update":true,"role.destroy":true,"role.permissions":true,"role.save":true}',
					'role' => 1,
					'langue' => 'en',
					'telephone' => '0000000',
					'slug' => str_randomize(10)
			]

		]);


		DB::table('roles')->insert([
			[
					'slug' 		=> 'admin',
					'name' 			=> 'Admin',
					'permissions' 	=> '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"user.index":true,"user.create":true,"user.store":true,"user.show":true,"user.edit":true,"user.update":true,"user.destroy":true,"user.permissions":true,"user.save":true,"user.activate":true,"user.deactivate":true,"role.index":true,"role.create":true,"role.store":true,"role.show":true,"role.edit":true,"role.update":true,"role.destroy":true,"role.permissions":true,"role.save":true,"pages.getroles":true}',
			]
	 ]);
	 DB::table('role_users')->insert([
			[
					'user_id' 		=> '1',
					'role_id' 			=> '1',
			]
	 ]);
	 DB::table('activations')->insert([
			[
					'user_id' 		=> '1',
					'code' 			=> '1S4u7lJzehk62xDm3DgYgXXYWtbHE6gSP',
					'completed' 			=> '1',
			]
	 ]);

   DB::table('annonces')->insert([
           [


               'titre' => 'test',
               'contenue' =>'On ne peut pas suprimer le test',
               'dateDebut' =>Carbon::parse('2020-01-01'),
               'dateFin' =>Carbon::parse('2020-01-01'),
               'prix' =>'20',
               'nombreCaratere' =>'4',
               'position' =>'1',
               'etat' => '1',
               'date_validation' =>Carbon::parse('2020-01-01'),
               'utilisateur' => '1',
               'partenaire' =>'1',
               'valider_par' => '1',
               'slug' => str_randomize(10)
           ]

       ]);

       DB::table('positionannonces')->insert([
           [
               'libelle' => 'test',
               'description' => 'NON SUPRIMABMABLE',
               'slug' => str_randomize(10)

           ]
       ]);

       DB::table('tarifannonces')->insert([
           [
               'prix_image' =>'3',
               'prix_caractere' =>'3',
               'nbre_caractere' =>'3',
               'devise' =>'Eco',
               'position' =>'1',
               'type_annonce' =>'1',
               'slug' => str_randomize(10)

           ]
       ]);

       DB::table('typeannonces')->insert([
           [
               'libelle' => 'test',
               'description' => 'NON SUPRIMABLE',
               'slug' => str_randomize(10)
           ]
       ]);


    }
}
