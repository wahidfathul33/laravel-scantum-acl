<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Yajra\Acl\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::Create([
            'name' => 'Admin', 
            'slug' => 'admin', 
            'description' => 'Admin', 
            'system' => true
        ]);

        Role::Create([
            'name' => 'Cashier', 
            'slug' => 'cashier', 
            'description' => 'Cashier', 
            'system' => true
        ]);
        
        Role::Create([
            'name' => 'Collector', 
            'slug' => 'collector', 
            'description' => 'Collector', 
            'system' => true
        ]);

    }
}
