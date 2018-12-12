<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'content' => 'hello',
            'is_parent' => 1,
            'channel_id' => '1',
            'parent_id' => '1',
            'creator' => '1',
            'type' => '1',
        ]);

        DB::table('posts')->insert([
            'content' => 'hello1',
            'is_parent' => 0,
            'channel_id' => '1',
            'parent_id' => '1',
            'creator' => '1',
            'type' => '1',
        ]);

        DB::table('posts')->insert([
            'content' => 'idiot',
            'is_parent' => 1,
            'channel_id' => '2',
            'parent_id' => '1',
            'creator' => '2',
            'type' => '0',
        ]);
    }
}
