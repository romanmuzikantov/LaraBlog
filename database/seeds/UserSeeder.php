<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nbrUser = max((int) $this->command->ask('How many users do you want to create ?', 20), 1);

        factory(User::class, $nbrUser)->create();
        factory(User::class)->states('john-doe')->create();

        $this->command->info("$nbrUser users has been created");
    }
}
