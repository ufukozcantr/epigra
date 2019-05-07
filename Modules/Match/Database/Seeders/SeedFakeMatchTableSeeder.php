<?php

namespace Modules\Match\Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Match\Entities\Match;
use Modules\Match\Entities\MatchUser;
use Modules\Match\Entities\Set;

class SeedFakeMatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $users = User::all();
        foreach($users as $key => $user) {

            Set::create([
                'name' => $faker->name,
                'set' => rand(1,6),
                'question' => rand(5,15),
                'created_by' => $users[0]->id
            ]);

            Match::create([
                'match' => $faker->name,
                'created_by' => $users[0]->id
            ]);

        }
    }
}
