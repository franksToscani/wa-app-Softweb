<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a predictable admin user for local development
        // Older MySQL schemas for this app may not have `email_verified_at`,
        // so we build arrays and insert via the query builder without that column.
        $adminModel = User::factory()->make([
            'username' => 'admin',
            'email' => 'admin@example.com',
        ]);

        // Use getAttributes() so hidden attributes (like password) are included
        $admin = $adminModel->getAttributes();
        // Remove `email_verified_at` if present to avoid inserting an unknown column
        unset($admin['email_verified_at']);
        $admin['created_at'] = now();
        $admin['updated_at'] = now();
        // Ensure password exists
        if (empty($admin['password'])) {
            $admin['password'] = Hash::make('password');
        }

        DB::table('users')->insert($admin);

        // Bulk create random users via factories, convert to arrays and strip
        // `email_verified_at` so we don't try to insert that column if it doesn't exist.
        $users = User::factory(50)->make()->map(function ($m) {
            $a = $m->getAttributes();
            unset($a['email_verified_at']);
            $a['created_at'] = now();
            $a['updated_at'] = now();
            if (empty($a['password'])) {
                $a['password'] = Hash::make('password');
            }
            return $a;
        })->toArray();

        DB::table('users')->insert($users);
    }
}
