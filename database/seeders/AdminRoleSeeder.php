<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            // Find existing 'admin' role (case-insensitive) or create it
            $role = DB::table('roles')
                ->whereRaw('LOWER(nome) = ?', [strtolower('admin')])
                ->first();

            if ($role) {
                $roleId = $role->id;
            } else {
                $roleId = DB::table('roles')->insertGetId([
                    'nome' => 'admin',
                    'descrizione' => 'Administrator role',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            // Assign user with id = 1 to admin role if not already assigned
            $assigned = DB::table('users_has_roles')
                ->where('users_id', 1)
                ->where('roles_id', $roleId)
                ->exists();

            if (! $assigned) {
                DB::table('users_has_roles')->insert([
                    'users_id' => 1,
                    'roles_id' => $roleId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
