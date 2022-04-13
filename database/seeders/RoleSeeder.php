<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'visitor',
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'organizer',
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'exhibitor',
            'guard_name' => 'web',
        ]);
    }
}
