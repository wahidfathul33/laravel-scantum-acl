<?php

namespace Database\Seeders;

use Yajra\Acl\Models\Permission;
use Yajra\Acl\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route as RouteFacade;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = $this->getAdminRole();
        $this->createPermissions($role);

        $user = $this->getUserAdmin();
        $this->addRole($role, $user);
    }

    /**
     * @return Role
     */
    protected function getAdminRole(): Role
    {
        return Role::find(1) ?? Role::create([
                'name' => 'Admin', 
                'slug' => 'admin', 
                'description' => 'All privileges', 
                'system' => true
            ]);
    }

    /**
     * @param Role $role
     */
    protected function createPermissions(Role $role): void
    {
        foreach (RouteFacade::getRoutes() as $route) {

            $permission = $this->persistPermission($route);

            $role->permissions()->attach($permission);
        }
    }

    /**
     * @return User
     */
    protected function getUserAdmin(): User
    {
        return User::find(1) ?? User::create([
                'name' => 'Admin', 
                'email' => 'admin@admin.com',
                'password' =>  Hash::make('admin')
            ]);
    }

    /**
     * @param Role $role
     * @param User $user
     */
    protected function addRole(Role $role, User $user): void
    {
        if (! $user->roles->contains($role)) {
            $user->roles()->attach($role);
        }
    }

    /**
     * @param $route
     * @return array
     */
    private function persistPermission($route)
    {
        $permission = [];
        foreach ($route->methods as $method) {
            if (in_array($method, ['HEAD', 'PATCH'])) {
                continue;
            }

            $permission = Permission::create([
                'name' => ucwords(str_replace('.', ' ', $route->getName())),
                'slug' => $route->getName() ? $route->getName() : $route->getActionName(),
                'resource' => $route->uri,
            ]);
        }

        return $permission;
    }
}