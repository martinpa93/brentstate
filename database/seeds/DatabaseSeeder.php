<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        


        /* factory(App\Contact::class, 10)->create(); */
        factory(App\User::class,1)->create()->each(function ($user) {
            $user->properties()->saveMany(
                factory(App\Property::class, 20)->make());
            $user->renters()->saveMany(
                factory(App\Renter::class, 20)->make());
            /* $user->contracts()->saveMany(
                factory(App\Contract::class, 5)->make()); */
        });



    }
}
