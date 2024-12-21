<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use App\Models\Feature;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\FeatureFactory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $userRole = Role::create(['name' => RolesEnum::User->value]);
       $commenterRole = Role::create(['name' => RolesEnum::Commenter->value]);
       $adminRole = Role::create(['name' => RolesEnum::Admin->value]);

       $manageFeaturesPermissions = Permission::create(
           ['name' => PermissionsEnum::ManageFeatures->value]
       );

        $manageCommentsPermissions = Permission::create(
            ['name' => PermissionsEnum::ManageComments->value]
        );

        $manageUsersPermissions = Permission::create(
            ['name' => PermissionsEnum::ManageUsers->value]
        );

        $manageUpvoteDownVotePermissions = Permission::create(
            ['name' => PermissionsEnum::UpvoteDownvote->value]
        );
        $userRole->givePermissionTo($manageUpvoteDownVotePermissions);
        $commenterRole->givePermissionTo($manageUpvoteDownVotePermissions, $manageCommentsPermissions);
        $adminRole->givePermissionTo(
            [$manageFeaturesPermissions, $manageCommentsPermissions, $manageUsersPermissions]
        );
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])->assignRole(RolesEnum::User);

        User::factory()->create([
            'name' => 'Commenter User',
            'email' => 'commenter@example.com',
        ])->assignRole(RolesEnum::Commenter);


        User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
    ])->assignRole(RolesEnum::Admin);

        Feature::factory(100)->create();
    }


}
