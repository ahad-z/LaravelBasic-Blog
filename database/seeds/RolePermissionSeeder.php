<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create roles
		$roleSuperAdmin = Role::create(['name' => 'superadmin']);
		$roleAdmin      = Role::create(['name' => 'admin']);
		$roleEditor     = Role::create(['name' => 'editor']);
		$roleUser       = Role::create(['name' => 'user']);

		//permission list as array

		$permissions = [
			// Dashboard
			[
				'group_name' => 'dashboard',
				'permissions' => [
					'dashboard.view',
					'dashboard.edit'
				],
			],
			//Post permission
			[
				'group_name' => 'post',
				'permissions' => [
					'post.create',
					'post.view',
					'post.edit',
					'post.delete',
					'post.approve'
				],
			],
			//Admin permission
			[
				'group_name' => 'admin',
				'permissions' => [
					'admin.create',
					'admin.view',
					'admin.edit',
					'admin.delete',
					'admin.approve',
				],
			],
			//roll permission
			[
				'group_name' => 'role',
				'permissions' => [
					'role.create',
					'role.view',
					'role.edit',
					'role.delete',
					'role.approve',
				],
			],
			//profile permission
			[
				'group_name' => 'profile',
				'permissions' => [
					'profile.view',
					'profile.edit'
				],
			]

		];
		//create and  assign permission

		foreach ($permissions as $group) {
			foreach ($group['permissions'] as $permission) {
				$permission = Permission::create(['name' => $permission,'group_name' => $group['group_name']]);
				$permission->assignRole($roleSuperAdmin);
			}
		}

    }
}
