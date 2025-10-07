<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Which guards do you want roles for?
        // If you only use 'web', set: $guards = ['web'];
        // If you use Sanctum tokens for APIs too, include 'api'.
        $guards = ['web', 'api'];

        $roles = [
            'superuser',
            'admin',
            'dispatcher',
        ];

        foreach ($guards as $guard) {
            foreach ($roles as $name) {
                // Idempotent: creates if missing, otherwise no-op
                Role::findOrCreate($name, $guard);
            }
        }
    }
}
