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

        $permissionName = [
            'view_ingredient',
            'view_any_ingredient',
            'create_ingredient',
            'update_ingredient',
            'restore_ingredient',
            'restore_any_ingredient',
            'replicate_ingredient',
            'reorder_ingredient',
            'delete_ingredient',
            'delete_any_ingredient',
            'force_delete_ingredient',
            'force_delete_any_ingredient',
            'view_recipe',
            'view_any_recipe',
            'create_recipe',
            'update_recipe',
            'restore_recipe',
            'restore_any_recipe',
            'replicate_recipe',
            'reorder_recipe',
            'delete_recipe',
            'delete_any_recipe',
            'force_delete_recipe',
            'force_delete_any_recipe',
            'page_MyProfilePage'

        ];

        $permissions = Permission::whereIn('name', $permissionName)->get();

        $moderator->givePermissionTo($permissions);
    }
}
