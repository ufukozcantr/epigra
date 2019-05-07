<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $adminRole = Role::create(['name' => 'admin']);
        $adminPermission = Permission::create(['name' => 'admin']);
        $adminRole->givePermissionTo($adminPermission);

        $examinerRole = Role::create(['name' => 'examiner']);
        $examinerPermission = Permission::create(['name' => 'login exam']);
        $examinerRole->givePermissionTo($examinerPermission);

        for($i = 0; $i < 5; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('123qwe'),
            ]);

            if($i == 0){
                $user->assignRole($adminRole);
                $user->givePermissionTo($adminPermission);
            }else{
                $user->assignRole($examinerRole);
                $user->givePermissionTo($examinerPermission);
            }
        }
    }
}
