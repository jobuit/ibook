<?php

use App\Autores;
use Illuminate\Database\Seeder;

class AutoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 1; $i < 31; $i++) {
            $name=$faker->name;
            try {
                Autores::create([
                    'nombre' => $name,
                    'descripcion' => $faker->paragraph,
                    'imagen' => '/img/autores/autor'.$i.'.jpeg',
                    'telefono' => $faker->phoneNumber,
                    'correo' => $name . '@gmail.com',
                    'valoracion' => random_int(0, 10),
                ]);
            } catch (Exception $e) {
            }
        }
    }
}
