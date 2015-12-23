<?php

use Illuminate\Database\Seeder;

class childrenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 10;
        for($i=1; $i<= $limit; $i++)
        {
            DB::table('children')->insert([
               'nom_enfant'=> $faker->name,
                'age_enfant' =>rand(1,6),
                'date_naissance'=>$faker->date(),
                'photo' => 'avatar4.jpg',
                'family_id' => rand(1,10),
                'user_id' => rand(1,10)
            ]);


        }
    }
}
