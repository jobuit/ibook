<?php

use App\Books;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $temas = array(
            'LITERATURA',
            'ROMÁNTICA',
            'FANTASÍA',
            'INFANTIL & JUVENIL',
            'TIEMPO LIBRE',
            'BIENESTAR',
            'PENSAMIENTO',
            'RELIGIÓN Y CREENCIAS',
        );
        for($i = 1; $i < 55; $i++) {
            Books::create([
                'autor_id' => random_int(1, 29),
                'titulo' => $faker->company,
                'descripcion' => $faker->text,
                'tema' => array_random($temas),
                'imagen' => '/img/libros/libro'.$i.'.jpeg',
                'valoracion' => random_int(0,10),
                'cantidad' => random_int(0, 50),
                'precio' => random_int(20000, 55000),
            ]);
        }
    }
}
