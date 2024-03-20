<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ModeratorRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $moderator = Role::create(['name' => 'moderator']);

        Artisan::call('shield:generate', ['--all' => true]);

        $permissions = Permission::all();

        $moderator->givePermissionTo($permissions);
    }
}
