<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DevAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates a predictable dev admin user with email dev+admin@example.com
     */
    public function run()
    {
    $email = 'devadmin@example.com';

        // Avoid duplicate key errors when seeding repeatedly
        $exists = DB::table('users')->where('email', $email)->exists();

        if ($exists) {
            // ensure password is known for automated login and get the existing user id
            DB::table('users')->where('email', $email)->update([
                'password' => Hash::make('password'),
            ]);

            $userId = DB::table('users')->where('email', $email)->value('id');
        } else {
            // create the user and capture id
            $userId = DB::table('users')->insertGetId([
                'username' => 'dev-admin',
                'email' => $email,
                'password' => Hash::make('password'),
                // set other common columns if present — nullable columns will be ignored by DB
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Ensure an 'admin' role exists and assign it to the user so middleware grants access.

        // Ensure an 'admin' role exists and assign it to the created user so middleware grants access.
        $role = DB::table('roles')->whereRaw('LOWER(nome) = ?', ['admin'])->first();

        if (! $role) {
            $roleId = DB::table('roles')->insertGetId([
                'nome' => 'admin',
                'descrizione' => 'Administrator role',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $roleId = $role->id;
        }

        $assigned = DB::table('users_has_roles')
            ->where('users_id', $userId)
            ->where('roles_id', $roleId)
            ->exists();

        if (! $assigned) {
            DB::table('users_has_roles')->insert([
                'users_id' => $userId,
                'roles_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
