<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'username' => 'asAdmin',
            'password' => bcrypt('123456'),
        ]);

        DB::table('admins')->insert([
            'username' => 'testadmin01',
            'password' => bcrypt('123456'),
        ]);

    }
}
