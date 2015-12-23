<?php

use Illuminate\Database\Seeder;

class familiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker = Faker\Factory::create();

        for($i= 1; $i<=10;$i++)
        {
            DB::table('families')->insert([
               'nom_pere' => $faker->name,
                'nom_mere'=> $faker->firstNameFemale.' '.$faker->lastName,
                'email_responsable' => $faker->unique()->email(),
                'adresse' =>$faker->address,
                'numero_fixe' =>$faker->phoneNumber,
                'numero_portable' => $faker->phoneNumber,
                'cin' =>$faker->postcode,
                'responsable' => rand(0,1)
            ]);
        }


    }
}
