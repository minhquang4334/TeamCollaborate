<?php

use Illuminate\Database\Seeder;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->insert([
            'type' => '0',
            'creator' => '1',
            'purpose' => 'for fun',
            'description' => 'No description',
            'status' => '0',
            'channel_id' => 'ch100'
        ]);
        DB::table('channels')->insert([
            'type' => '0',
            'creator' => '2',
            'purpose' => 'for fun',
            'description' => 'No description',
            'status' => '0',
            'channel_id' => 'ch101'
        ]);
        DB::table('channels')->insert([
            'type' => '0',
            'creator' => '2',
            'purpose' => 'for fun',
            'description' => 'No description',
            'status' => '0',
            'channel_id' => 'ch102'
        ]);
    }
}
