<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jonatan Buitrago',
            'email' => 'jobuit20@gmail.com',
            'account' => 'user',
            'address' => 'B/ Virginia M1 #12',
            'num_reservas' => 0,
            'phone_number' => '3104054294',
            'password' => Hash::make('123456'),
        ]);

        $faker = Faker\Factory::create();
        for($i = 0; $i < 30; $i++) {
            $name=$faker->userName;
            User::create([
                'name' => $name,
                'email' => $name.'@gmail.com',
                'account' => 'user',
                'address' => $faker->address,
                'num_reservas' => 0,
                'phone_number' => $faker->phoneNumber,
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
